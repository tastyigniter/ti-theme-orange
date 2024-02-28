<?php

namespace Igniter\Orange\Livewire;

use Exception;
use Igniter\Cart\Classes\CartManager;
use Igniter\Cart\Classes\OrderManager;
use Igniter\Cart\Models\Order;
use Igniter\Flame\Exception\ApplicationException;
use Igniter\Flame\Traits\EventEmitter;
use Igniter\Local\Facades\Location;
use Igniter\Orange\Livewire\Forms\CheckoutForm;
use Igniter\System\Facades\Assets;
use Igniter\System\Models\Country;
use Igniter\User\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Event;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Livewire;

class Checkout extends \Livewire\Component
{
    use EventEmitter;

    public const STEP_DETAILS = 'details';

    public const STEP_PAY = 'pay';

    public CheckoutForm $form;

    /** Whether to use a multi step checkout */
    public bool $isTwoStepCheckout = false;

    /** Whether to display the address 2 form field */
    public bool $showAddress2Field = true;

    /** Whether to display the city form field */
    public bool $showCityField = true;

    /** Whether to display the state form field */
    public bool $showStateField = true;

    /** Whether to display the country form field */
    public bool $showCountryField = false;

    /** Whether to display the postcode form field */
    public bool $showPostcodeField = true;

    /** Whether the telephone field should be required */
    public bool $showTelephoneField = true;

    /** Whether to display the comment form field */
    public bool $showCommentField = true;

    /** Whether to display the delivery comment form field */
    public bool $showDeliveryCommentField = true;

    /** The permalink slug for the agree checkout terms page */
    public string $agreeTermsSlug = 'terms-and-conditions';

    /** The checkout page */
    public string $menusPage = 'local'.DIRECTORY_SEPARATOR.'menus';

    /** The checkout page */
    public string $checkoutPage = 'checkout'.DIRECTORY_SEPARATOR.'checkout';

    /** Page to redirect to when checkout is successful */
    public string $successPage = 'checkout'.DIRECTORY_SEPARATOR.'success';

    #[Url(as: 'step')]
    public string $checkoutStep = 'details';

    /**
     * @var \Igniter\Cart\Classes\CartManager
     */
    protected $cartManager;

    /**
     * @var \Igniter\Cart\Classes\OrderManager
     */
    protected $orderManager;

    /**
     * @var \Igniter\Cart\Models\Order
     */
    protected $order;

    public function render()
    {
        return view('igniter-orange::livewire.checkout', [
            'customer' => Auth::customer(),
            'order' => $order = $this->getOrder(),
            'locationCurrent' => Location::current(),
            'locationOrderType' => Location::getOrderTypes()->get($order->order_type),
        ]);
    }

    public function mount()
    {
        if ($redirect = $this->isOrderMarkedAsProcessed()) {
            return $redirect;
        }

        if ($this->checkCheckoutSecurity()) {
            return $this->redirect(restaurant_url($this->menusPage));
        }

        Assets::addJs('igniter-orange::/js/checkout.js', 'checkout-js');

        foreach ($this->paymentGateways as $paymentGateway) {
            $paymentGateway->beforeRenderPaymentForm($paymentGateway, controller());
        }

        $order = $this->getOrder();
        $this->form->requiresAddress = $order->isDeliveryType();
        $this->form->first_name = $order->first_name;
        $this->form->last_name = $order->last_name;
        $this->form->email = $order->email;
        $this->form->telephone = $order->telephone;
        $this->form->comment = $order->comment;
        $this->form->delivery_comment = $order->delivery_comment;
        $this->form->address_id = $order->address_id;
        $this->form->payment = $order->payment;

        $this->prepareDeliveryAddress();
    }

    public function boot()
    {
        $this->orderManager = resolve(OrderManager::class);
        $this->cartManager = resolve(CartManager::class);
    }

    public function updating($property, $value)
    {
        if ($property === 'form.address_id' && is_numeric($value)) {
            $this->form->address_id = $value;
            $this->prepareDeliveryAddress();
        }
    }

    #[Computed, Locked]
    public function customerAddresses()
    {
        return $this->getOrder()->listCustomerAddresses();
    }

    #[Computed, Locked]
    public function paymentGateways()
    {
        return $this->getOrder()?->order_total > 0
            ? $this->orderManager->getPaymentGateways()
            : collect();
    }

    #[On('checkout::validate')]
    public function onValidate()
    {
        if ($this->checkCheckoutSecurity()) {
            return $this->redirect(restaurant_url($this->menusPage));
        }

        if ($redirect = $this->isOrderMarkedAsProcessed()) {
            return $redirect;
        }

        $order = $this->getOrder();

        $this->prepareDeliveryAddress();

        $data = $this->validateCheckout($order);

        $this->orderManager->saveOrder($order, $data);

        $this->dispatch('checkout::validated');
    }

    #[On('checkout::confirm')]
    public function onConfirm()
    {
        if ($this->checkCheckoutSecurity()) {
            return $this->redirect(restaurant_url($this->menusPage));
        }

        if ($redirect = $this->isOrderMarkedAsProcessed()) {
            return $redirect;
        }

        $order = $this->getOrder();

        $this->prepareDeliveryAddress();

        $data = $this->validateCheckout($order);

        $data['cancelPage'] = $this->checkoutPage;
        $data['successPage'] = $this->successPage;

        $this->orderManager->saveOrder($order, $data);

        if ($this->isTwoStepCheckout && $this->checkoutStep !== self::STEP_PAY) {
            return redirect()->to(Livewire::originalUrl().'?step='.static::STEP_PAY);
        }

        try {
            if (($redirect = $this->orderManager->processPayment($order, $data)) === false) {
                return;
            }

            if ($redirect instanceof RedirectResponse) {
                return $redirect;
            }

            if ($redirect = $this->isOrderMarkedAsProcessed()) {
                return $redirect;
            }
        } catch (\Exception $ex) {
            throw ValidationException::withMessages(['form.payment' => $ex->getMessage()]);
        }
    }

    #[On('checkout::choose-payment')]
    public function onChoosePayment($code)
    {
        throw_unless($code, ValidationException::withMessages([
            'form.payment' => lang('igniter.cart::default.checkout.error_invalid_payment'),
        ]));

        throw_unless($payment = $this->orderManager->getPayment($code), ValidationException::withMessages([
            'form.payment' => lang('igniter.cart::default.checkout.error_invalid_payment'),
        ]));

        $this->form->payment = $code;
        $this->orderManager->applyCurrentPaymentFee($payment->code);
    }

    #[On('checkout::delete-payment-profile')]
    public function onDeletePaymentProfile($code)
    {
        $customer = Auth::customer();
        $payment = $this->orderManager->getPayment($code);

        throw_if(!$payment || !$payment->paymentProfileExists($customer), ValidationException::withMessages([
            'form.payment' => lang('igniter.cart::default.checkout.error_invalid_payment'),
        ]));

        $payment->deletePaymentProfile($customer);
    }

    protected function getOrder()
    {
        if (!is_null($this->order)) {
            return $this->order;
        }

        $order = $this->orderManager->loadOrder();

        if (!$order->isPaymentProcessed()) {
            $this->orderManager->applyRequiredAttributes($order);
        }

        return $this->order = $order;
    }

    protected function checkCheckoutSecurity()
    {
        try {
            $this->fireSystemEvent('igniter.cart.beforeCheckCheckoutSecurity', [$this]);

            $this->cartManager->validateContents();

            $this->orderManager->validateCustomer(Auth::getUser());

            $this->cartManager->validateLocation();

            $this->cartManager->validateOrderTime();

            if ($this->cartManager->cartTotalIsBelowMinimumOrder()) {
                throw new ApplicationException(sprintf(lang('igniter.cart::default.alert_min_order_total'),
                    currency_format(resolve('location')->minimumOrderTotal())));
            }

            if ($this->cartManager->deliveryChargeIsUnavailable()) {
                return true;
            }
        } catch (Exception $ex) {
            flash()->warning($ex->getMessage())->now();

            return true;
        }
    }

    protected function validateCheckout(Order $order)
    {
        $this->form->requiresAddress = $order->isDeliveryType();

        $this->form->withValidator(function ($validator) use ($order) {
            $validator->after(function ($validator) use ($order) {
                if ($order->isDeliveryType()) {
                    rescue(function () {
                        $this->orderManager->validateDeliveryAddress($this->form->toArray());
                    }, function (\Exception $ex) use ($validator) {
                        $validator->errors()->add('address_1', $ex->getMessage());
                    });
                }

                if (!$this->orderManager->getPayment($this->form->payment)) {
                    $validator->errors()->add('payment', lang('igniter.cart::default.checkout.error_invalid_payment'));
                }
            });
        });

        $data = $this->form->validate();

        $this->orderManager->applyCurrentPaymentFee($this->form->payment);

        Event::fire('igniter.checkout.afterValidate', [$data, $order]);

        return $data;
    }

    protected function isOrderMarkedAsProcessed()
    {
        $order = $this->getOrder();
        if (!$order->isPaymentProcessed()) {
            return false;
        }

        return $this->redirect($order->getUrl($this->successPage), navigate: true);
    }

    protected function prepareDeliveryAddress()
    {
        if (!$this->form->requiresAddress) {
            return;
        }

        if ($address = $this->getSelectedAddress()) {
            $this->form->address_1 = $address->address_1;
            $this->form->address_2 = $address->address_2;
            $this->form->city = $address->city;
            $this->form->state = $address->state;
            $this->form->postcode = $address->postcode;
        } elseif ($userPosition = Location::userPosition()) {
            $this->form->address_1 = $userPosition->getStreetNumber().' '.$userPosition->getStreetName();
            $this->form->city = $userPosition->getSubLocality();
            $this->form->state = $userPosition->getLocality();
            $this->form->postcode = $userPosition->getPostalCode();
        }

        if (!isset($this->form->country_id)) {
            $this->form->country_id = Country::getDefaultKey();
        }
    }

    protected function getSelectedAddress()
    {
        return $this->form->address_id
            ? $this->orderManager->findDeliveryAddress($this->form->address_id)
            : null;
    }
}
