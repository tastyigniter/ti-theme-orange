<?php

namespace Igniter\Orange\Livewire;

use Exception;
use Igniter\Cart\Classes\CartManager;
use Igniter\Cart\Classes\OrderManager;
use Igniter\Flame\Exception\ApplicationException;
use Igniter\Main\Helpers\MainHelper;
use Igniter\User\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;

class OrderPreview extends \Livewire\Component
{
    /** The parameter name used for the order hash code */
    public string $hashParamName = 'hash';

    public string $hash;

    public string $loginPage = 'account'.DIRECTORY_SEPARATOR.'login';

    /** Account Orders Page */
    public string $ordersPage = 'account'.DIRECTORY_SEPARATOR.'orders';

    public string $checkoutPage = 'checkout'.DIRECTORY_SEPARATOR.'checkout';

    /** Menus Page, page to redirect to when a user clicks the re-order button */
    public string $menusPage = 'local'.DIRECTORY_SEPARATOR.'menus';

    public string $loginUrl = '';

    /** Whether to hide the reorder button, should be hidden on the checkout success page */
    public bool $hideReorderBtn = true;

    public bool $showCancelButton = false;

    protected OrderManager $orderManager;

    protected ?Model $order = null;

    public function render()
    {
        return view('igniter-orange::livewire.order-preview', [
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
        $this->hash = request()->route()->parameter($this->hashParamName);
        $this->showCancelButton = $this->showCancelButton();

        if (!$processedOrder = $this->getProcessedOrder()) {
            return $this->redirect(MainHelper::pageUrl(Auth::customer() ? $this->ordersPage : $this->checkoutPage));
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

    public function showCancelButton()
    {
        return $this->getProcessedOrder() && !$this->getProcessedOrder()->isCanceled() && $this->getProcessedOrder()->isCancelable();
    }

    public function onReOrder()
    {
        throw_unless($order = $this->getProcessedOrder(), ValidationException::withMessages([
            'onReOrder' => lang('igniter.cart::default.orders.alert_reorder_failed'),
        ]));

        rescue(function () use ($order) {
            if ($notes = resolve(CartManager::class)->addOrderMenus($order))
                throw new ApplicationException(implode(PHP_EOL, $notes));
        }, function (Exception $ex) {
            throw ValidationException::withMessages(['onReOrder' => $ex->getMessage()]);
        });

        flash()->success(sprintf(
            lang('igniter.cart::default.orders.alert_reorder_success'), $order->order_id
        ));

        return $this->redirect(page_url($this->menusPage, [
            'orderId' => $order->order_id,
            'location' => $order->location->permalink_slug,
        ]));
    }

    public function onCancel()
    {
        throw_unless($order = $this->getProcessedOrder(), ValidationException::withMessages([
            'onCancel' => lang('igniter.cart::default.orders.alert_cancel_failed'),
        ]));

        throw_unless($this->showCancelButton(), ValidationException::withMessages([
            'onCancel' => lang('igniter.cart::default.orders.alert_cancel_failed'),
        ]));

        throw_unless($order->markAsCanceled(), ValidationException::withMessages([
            'onCancel' => lang('igniter.cart::default.orders.alert_cancel_failed'),
        ]));

        flash()->success(lang('igniter.cart::default.orders.alert_cancel_success'));
    }

    protected function getProcessedOrder()
    {
        return $this->order ??= $this->orderManager->getOrderByHash($this->hash, Auth::customer());
    }

    protected function getLoginPageUrl()
    {
        $currentUrl = str_before(request()->fullUrl(), request()->root());

        return page_url($this->loginPage).'?redirect='.urlencode($currentUrl);
    }
}
