<?php

namespace Igniter\Orange\Livewire;

use Igniter\Cart\Classes\CartManager;
use Igniter\Cart\Models\CartSettings;
use Igniter\Flame\Exception\ApplicationException;
use Igniter\Local\Facades\Location;
use Igniter\Main\Traits\ConfigurableComponent;
use Igniter\Main\Traits\UsesPage;
use Igniter\System\Facades\Assets;
use Illuminate\Support\Facades\Redirect;
use Livewire\Attributes\On;
use Livewire\Component;

class CartBox extends Component
{
    use ConfigurableComponent;
    use UsesPage;

    /** Checkout Page */
    public string $checkoutPage = 'checkout.checkout';

    public int|float $tipAmount = 0;

    public bool $isCustomTip = false;

    public ?string $couponCode = null;

    /**
     * @var \Igniter\Cart\Classes\CartManager
     */
    protected $cartManager;

    protected $listeners = ['hideModal' => '$refresh'];

    public static function componentMeta(): array
    {
        return [
            'code' => 'igniter-orange::cart-box',
            'name' => 'igniter.orange::default.component_cartbox_title',
            'description' => 'igniter.orange::default.component_cartbox_desc',
        ];
    }

    public function defineProperties(): array
    {
        return [
            'checkoutPage' => [
                'label' => 'Page to redirect to when the checkout button is clicked.',
                'type' => 'select',
                'options' => [static::class, 'getThemePageOptions'],
                'default' => 'checkout.checkout',
                'validationRule' => 'required|regex:/^[a-z0-9\-_\/]+$/i',
            ],
        ];
    }

    public function render()
    {
        return view('igniter-orange::livewire.cart-box', [
            'previewMode' => false,
            'location' => Location::getFacadeRoot(),
            'cart' => $this->cartManager->getCart(),
        ]);
    }

    public function mount()
    {
        Assets::addJs('igniter-orange::/js/cart-item-options.js', 'cart-item-options-js');
        Assets::addJs('igniter-orange::/js/cart-item.js', 'cart-item-js');

        $this->prepareProps();
    }

    public function boot()
    {
        $this->cartManager = resolve(CartManager::class);
    }

    public function updated($property, $value)
    {
        if ($property === 'tipAmount') {
            $this->onApplyTip($value, true);
        }
    }

    public function onOpenItemModal(string $rowId, int $menuId)
    {
        $this->dispatch('showModal', component: 'igniter-orange::cart-item-modal', arguments: ['menuId' => $menuId, 'rowId' => $rowId]);
    }

    #[On('cart-box:add-item')]
    public function onUpdateItem(int $menuId, ?string $rowId = null, ?int $quantity = null)
    {
        $this->cartManager->addOrUpdateCartItem([
            'menuId' => $menuId,
            'rowId' => $rowId,
            'quantity' => $quantity,
        ]);
    }

    public function onUpdateItemQuantity(string $rowId, string $action = 'plus')
    {
        $this->cartManager->updateCartItemQty($rowId, $action);
    }

    public function onApplyCoupon()
    {
        $this->cartManager->applyCouponCondition($this->couponCode);
    }

    public function onApplyTip(int|float $amount, bool $isCustom = false)
    {
        if (preg_match('/^\d+([\.\d]{2})?([%])?$/', $amount) === false) {
            throw new ApplicationException(lang('igniter.cart::default.alert_tip_not_applied'));
        }

        $this->cartManager->applyCondition('tip', [
            'isCustom' => $isCustom,
            'amount' => $amount,
        ]);

        $this->prepareProps();
    }

    public function onRemoveCondition(string $conditionName)
    {
        throw_unless(strlen($conditionName), new ApplicationException(
            lang('igniter.cart::default.alert_condition_not_found')
        ));

        $this->cartManager->removeCondition($conditionName);
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

        if ($this->cartManager->getCart()->count()) {
            return lang('igniter.cart::default.button_order').' · '.currency_format($this->cartManager->getCart()->total());
        }

        return lang('igniter.cart::default.button_order');
    }

    public function getLocationId()
    {
        return Location::getId();
    }

    public function tippingEnabled()
    {
        return CartSettings::tippingEnabled();
    }

    public function tippingAmounts()
    {
        return CartSettings::tippingAmounts();
    }

    protected function prepareProps()
    {
        $this->couponCode = $this->cartManager->getCart()->getCondition('coupon')?->getMetaData('code');

        $this->tipAmount = $this->cartManager->getCart()->getCondition('tip')?->getMetaData('amount', 0) ?? 0;
        $this->isCustomTip = (bool)$this->cartManager->getCart()->getCondition('tip')?->getMetaData('isCustom');
    }
}
