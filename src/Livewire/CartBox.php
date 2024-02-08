<?php

namespace Igniter\Orange\Livewire;

use Igniter\Cart\Classes\CartManager;
use Igniter\Cart\Models\CartSettings;
use Igniter\Flame\Exception\ApplicationException;
use Igniter\Local\Facades\Location;
use Igniter\System\Facades\Assets;
use Illuminate\Support\Facades\Redirect;
use Livewire\Attributes\On;
use Livewire\Livewire;

class CartBox extends \Livewire\Component
{
    public bool $checkStockCheckout = true;

    /** Whether this component is loaded on the checkout page */
    public bool $pageIsCheckout = false;

    /** Whether to show the proceed to checkout button */
    public bool $showCheckoutButton = true;

    /** Checkout Page */
    public string $checkoutPage = 'checkout'.DIRECTORY_SEPARATOR.'checkout';

    /**
     * @var \Igniter\Cart\Classes\CartManager
     */
    protected $cartManager;

    public function render()
    {
        return view('igniter-orange::livewire.cart-box', [
            'cart' => $this->cartManager->getCart(),
        ]);
    }

    public function mount()
    {
        Assets::addJs('igniter-orange::/js/cart-item-options.js', 'cart-item-options-js');
        Assets::addJs('igniter-orange::/js/cart-item.js', 'cart-item-js');
    }

    public function boot()
    {
        $this->cartManager = resolve(CartManager::class)->checkStock($this->checkStockCheckout);
    }

    public function onOpenItemModal(string $rowId, int $menuId)
    {
        $this->dispatch('openModal', component: 'igniter-orange::cart-item-modal', arguments: ['menuId' => $menuId, 'rowId' => $rowId]);
    }

    #[On('cart-box::add-item')]
    public function onUpdateItem(int $menuId, ?string $rowId = null)
    {
        $this->cartManager->addOrUpdateCartItem([
            'menuId' => $menuId,
            'rowId' => $rowId,
        ]);

        return $this->redirect(Livewire::originalUrl(), navigate: true);
    }

    public function onUpdateItemQuantity(string $rowId, string $action = 'plus')
    {
        $this->cartManager->updateCartItemQty($rowId, $action);
    }

    public function onRemoveItem(string $rowId)
    {
        return $this->removeCartItem($rowId);
    }

    public function onApplyCoupon(?string $code = null)
    {
        $this->cartManager->applyCouponCondition($code);
    }

    public function onApplyTip(float $amount, bool $isCustom = false)
    {
        if (preg_match('/^\d+([\.\d]{2})?([%])?$/', $amount) === false) {
            throw new ApplicationException(lang('igniter.cart::default.alert_tip_not_applied'));
        }

        $this->cartManager->applyCondition('tip', [
            'isCustom' => $isCustom,
            'amount' => $amount,
        ]);
    }

    public function onRemoveCondition()
    {
        if (!strlen($conditionId = post('conditionId'))) {
            return;
        }

        $this->cartManager->removeCondition($conditionId);
        $this->controller->pageCycle();

        return $this->fetchPartials();
    }

    public function onProceedToCheckout(int $locationId)
    {
        if (!$locationId || !($location = Location::getById($locationId)) || !$location->location_status) {
            throw new ApplicationException(lang('igniter.local::default.alert_location_required'));
        }

        Location::setCurrent($location);

        throw_if($this->locationIsClosed(), new ApplicationException(lang('igniter.cart::default.alert_location_closed')));

        throw_if($this->hasMinimumOrder(), new ApplicationException(
            sprintf(lang('igniter.local::default.alert_order_is_unavailable'), Location::orderType())
        ));

        return Redirect::to(page_url($this->checkoutPage));
    }

    public function locationIsClosed()
    {
        return !Location::checkOrderTime() || Location::checkNoOrderTypeAvailable();
    }

    public function hasMinimumOrder()
    {
        return $this->cartManager->cartTotalIsBelowMinimumOrder()
            || $this->cartManager->deliveryChargeIsUnavailable();
    }

    public function buttonLabel($checkoutComponent = null)
    {
        if ($this->locationIsClosed()) {
            return lang('igniter.cart::default.text_is_closed');
        }

        if (!$this->pageIsCheckout && $this->cartManager->getCart()->count()) {
            return lang('igniter.cart::default.button_order').' · '.currency_format($this->cartManager->getCart()->total());
        }

        if (!$this->pageIsCheckout) {
            return lang('igniter.cart::default.button_order');
        }

        if ($checkoutComponent && !$checkoutComponent->canConfirmCheckout()) {
            return lang('igniter.cart::default.button_payment');
        }

        return lang('igniter.cart::default.button_confirm');
    }

    public function getLocationId()
    {
        return Location::getId();
    }

    public function tippingEnabled()
    {
        return (bool)CartSettings::get('enable_tipping');
    }

    public function tippingAmounts()
    {
        $result = [];

        $tipValueType = CartSettings::get('tip_value_type', 'F');
        $amounts = (array)CartSettings::get('tip_amounts', []);

        $amounts = sort_array($amounts, 'priority');

        foreach ($amounts as $index => $amount) {
            $amount['valueType'] = $tipValueType;
            $result[$index] = (object)$amount;
        }

        return $result;
    }

    public function tippingSelectedAmount()
    {
        return optional($this->cartManager->getCart()->getCondition('tip'))->getMetaData('amount', 0) ?? 0;
    }

    public function tippingSelectedTypeIsCustom()
    {
        return (bool)optional($this->cartManager->getCart()->getCondition('tip'))->getMetaData('isCustom');
    }
}
