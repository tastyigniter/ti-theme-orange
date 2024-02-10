<?php

namespace Igniter\Orange\Livewire\Pages;

use Exception;
use Igniter\Cart\Classes\CartManager;
use Igniter\Cart\Classes\OrderManager;
use Igniter\Cart\Facades\Cart;
use Igniter\Cart\Models\Menu;
use Igniter\Cart\Models\Order as OrderModel;
use Igniter\Flame\Exception\ApplicationException;
use Igniter\Main\Helpers\MainHelper;
use Igniter\User\Facades\Auth;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redirect;

class ShowOrder extends \Livewire\Component
{
    /** The parameter name used for the order hash code */
    public string $hashParamName = 'hash';

    public string $loginPage = 'account'.DIRECTORY_SEPARATOR.'login';

    /** Account Orders Page */
    public string $ordersPage = 'account'.DIRECTORY_SEPARATOR.'orders';

    public string $checkoutPage = 'checkout'.DIRECTORY_SEPARATOR.'checkout';

    /** Menus Page, page to redirect to when a user clicks the re-order button */
    public string $menusPage = 'local'.DIRECTORY_SEPARATOR.'menus';

    public string $loginUrl = '';

    /** Whether to hide the reorder button, should be hidden on the checkout success page */
    public bool $hideReorderBtn = true;

    /**
     * @var \Igniter\Cart\Classes\OrderManager
     */
    protected $orderManager;

    protected null|Model $order = null;

    public function render()
    {
        return view('igniter-orange::livewire.pages.show-order', [
            'customer' => Auth::customer(),
            'order' => $this->getProcessedOrder(),
        ]);
    }

    public function boot()
    {
        $this->orderManager = resolve(OrderManager::class);
    }

    public function mount()
    {
        $this->loginUrl = $this->getLoginPageUrl();

        if (!$processedOrder = $this->getProcessedOrder()) {
            return Redirect::to(MainHelper::pageUrl(Auth::customer() ? $this->ordersPage : $this->checkoutPage));
        }

        if ($this->orderManager->isCurrentOrderId($processedOrder?->order_id)) {
            $this->orderManager->clearOrder();
        }
    }

    public function getStatusWidthForProgressBars()
    {
        $result = [];

        $order = $this->getProcessedOrder();

        $result['default'] = 0;
        $result['processing'] = 0;
        $result['completed'] = 0;

        if ($order->status_id == setting('default_order_status')) {
            $result['default'] = 50;
        }

        if (in_array($order->status_id, setting('processing_order_status', []))) {
            $result['default'] = 100;
            $result['processing'] = 50;
        }

        if (in_array($order->status_id, setting('completed_order_status', []))) {
            $result['default'] = 100;
            $result['processing'] = 100;
            $result['completed'] = 100;
        }

        return $result;
    }

    public function showCancelButton($order = null)
    {
        if (is_null($order) && !$order = $this->getProcessedOrder()) {
            return false;
        }

        return !$order->isCanceled() && $order->isCancelable();
    }

    public function onRun()
    {
        $this->page['ordersPage'] = $this->property('ordersPage');
        $this->page['hideReorderBtn'] = $this->property('hideReorderBtn');
        $this->page['orderDateTimeFormat'] = lang('system::lang.moment.date_time_format_short');

        $this->page['hashParam'] = $this->param('hash');
        $this->page['order'] = $order = $this->getProcessedOrder();

        $this->addJs('js/order.js', 'checkout-js');

        if (!$order || !$order->isPaymentProcessed()) {
            return Redirect::to($this->property('ordersPage'));
        }

        if ($this->orderManager->isCurrentOrderId($order->order_id)) {
            $this->orderManager->clearOrder();
        }
    }

    public function onReOrder($orderId = null)
    {
        if (!$orderId || !$order = OrderModel::find($orderId)) {
            return;
        }

        foreach ($order->getOrderMenus() as $orderMenu) {
            if (!$menuModel = Menu::findBy($orderMenu->menu_id)) {
                continue;
            }

            $this->addCartItem($menuModel, $orderMenu);
        }

        flash()->success(sprintf(
            lang('igniter.cart::default.orders.alert_reorder_success'), $orderId
        ));

        $menusPage = $this->property('menusPage');

        return Redirect::to($this->controller->pageUrl($menusPage, [
            'orderId' => $orderId,
            'location' => $order->location->permalink_slug,
        ]));
    }

    public function onCancel()
    {
        if (!is_numeric($orderId = input('orderId'))) {
            return;
        }

        if (!$order = OrderModel::find($orderId)) {
            return;
        }

        if (!$this->showCancelButton($order)) {
            throw new ApplicationException(lang('igniter.cart::default.orders.alert_cancel_failed'));
        }

        if (!$order->markAsCanceled()) {
            throw new ApplicationException(lang('igniter.cart::default.orders.alert_cancel_failed'));
        }

        flash()->success(lang('igniter.cart::default.orders.alert_cancel_success'));

        return redirect()->back();
    }

    protected function getProcessedOrder()
    {
        if ($this->order) {
            return $this->order;
        }

        if (!is_string($hash = request()->route($this->hashParamName))) {
            return null;
        }

        $order = $this->orderManager->getOrderByHash($hash, Auth::customer());
        if ($order && !$order->isPaymentProcessed()) {
            return null;
        }

        return $this->order = $order;
    }

    protected function addCartItem($menuModel, $orderMenu): void
    {
        try {
            resolve(CartManager::class)->validateCartMenuItem($menuModel, $orderMenu->quantity);

            if (is_string($orderMenu->option_values)) {
                $orderMenu->option_values = @unserialize($orderMenu->option_values);
            }

            if ($orderMenu->option_values instanceof Arrayable) {
                $orderMenu->option_values = $orderMenu->option_values->toArray();
            }

            $options = $this->prepareCartItemOptions($menuModel, $orderMenu->option_values);

            Cart::add($menuModel, $orderMenu->quantity, $options, $orderMenu->comment);
        } catch (Exception $ex) {
            flash()->warning($ex->getMessage());
        }
    }

    protected function prepareCartItemOptions($menuModel, $optionValues)
    {
        $options = [];
        foreach ($optionValues as $cartOption) {
            if (!$menuOption = $menuModel->menu_options->keyBy('menu_option_id')->get($cartOption['id'])) {
                continue;
            }

            try {
                resolve(CartManager::class)->validateMenuItemOption($menuOption, $cartOption['values']->toArray());

                $cartOption['values'] = $cartOption['values']->filter(function ($cartOptionValue) use ($menuOption) {
                    return $menuOption->menu_option_values->keyBy('menu_option_value_id')->has($cartOptionValue->id);
                })->toArray();

                $options[] = $cartOption;
            } catch (Exception $ex) {
                flash()->warning($ex->getMessage());
            }
        }

        return $options;
    }

    protected function getLoginPageUrl()
    {
        $currentUrl = str_before(request()->fullUrl(), request()->root());

        return page_url($this->loginPage).'?redirect='.urlencode($currentUrl);
    }
}
