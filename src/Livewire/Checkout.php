<?php

namespace Igniter\Orange\Livewire;

use Exception;
use Igniter\Cart\Classes\CartManager;
use Igniter\Cart\Classes\OrderManager;
use Igniter\Cart\Models\Order;
use Igniter\Flame\Exception\ApplicationException;
use Igniter\Flame\Traits\EventEmitter;
use Igniter\Local\Facades\Location;
use Igniter\Main\Traits\ConfigurableComponent;
use Igniter\Main\Traits\UsesPage;
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
use Livewire\Component;
use Livewire\Livewire;

class Checkout extends Component
{
    use ConfigurableComponent;
    use EventEmitter;
    use UsesPage;

    public const STEP_DETAILS = 'details';

    public const STEP_PAY = 'pay';

    public CheckoutForm $form;

    /** Whether to use a two page checkout */
    public bool $isTwoPageCheckout = false;

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

    /** Whether the telephone field should be required */
    public bool $telephoneIsRequired = true;

    /** The permalink slug for the agree checkout terms page */
    public string $agreeTermsSlug = 'terms-and-conditions';

    /** The checkout page */
    public string $menusPage = 'local.menus';

    /** The checkout page */
    public string $checkoutPage = 'checkout.checkout';

    /** Page to redirect to when checkout is successful */
    public string $successPage = 'checkout.success';

    #[Url(as: 'step')]
    public string $checkoutStep = 'details';

    public array $paymentFields = [];

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

    public static function componentMeta(): array
    {
        return [
            'code' => 'igniter-orange::checkout',
            'name' => 'igniter.orange::default.component_checkout_title',
            'description' => 'igniter.orange::default.component_checkout_desc',
        ];
    }

    public function defineProperties(): array
    {
        return [
            'isTwoPageCheckout' => [
                'label' => 'Use two-page checkout.',
                'type' => 'switch',
                'validationRule' => 'required|boolean',
            ],
            'showAddress2Field' => [
                'label' => 'Display the address 2 checkout field.',
                'type' => 'switch',
                'validationRule' => 'required|boolean',
            ],
            'showCityField' => [
                'label' => 'Display the city checkout field.',
                'type' => 'switch',
                'validationRule' => 'required|boolean',
            ],
            'showStateField' => [
                'label' => 'Display the state checkout field.',
                'type' => 'switch',
                'validationRule' => 'required|boolean',
            ],
            'showPostcodeField' => [
                'label' => 'Display the postcode checkout field.',
                'type' => 'switch',
                'validationRule' => 'required|boolean',
            ],
            'showTelephoneField' => [
                'label' => 'Display the telephone checkout field.',
                'type' => 'switch',
                'validationRule' => 'required|boolean',
            ],
            'showCountryField' => [
                'label' => 'Display the country checkout field.',
                'type' => 'switch',
                'validationRule' => 'required|boolean',
            ],
            'showCommentField' => [
                'label' => 'Display the comment checkout field',
                'type' => 'switch',
                'validationRule' => 'required|boolean',
            ],
            'showDeliveryCommentField' => [
                'label' => 'Display the delivery comment checkout field',
                'type' => 'switch',
                'validationRule' => 'required|boolean',
            ],
            'telephoneIsRequired' => [
                'label' => 'Require telephone number for checkout',
                'type' => 'switch',
                'validationRule' => 'required|boolean',
            ],
            'agreeTermsSlug' => [
                'label' => 'Static page for the checkout terms and conditions',
                'type' => 'select',
                'options' => [static::class, 'getStaticPageOptions'],
                'comment' => 'If set, require customers to agree to terms before checkout',
                'validationRule' => 'sometimes|alpha_dash',
            ],
            'menusPage' => [
                'label' => 'Page to redirect to when checkout is unavailable.',
                'type' => 'select',
                'options' => [static::class, 'getThemePageOptions'],
                'validationRule' => 'required|regex:/^[a-z0-9\-_\.]+$/i',
            ],
            'checkoutPage' => [
                'label' => 'Page to redirect to when checkout fails',
                'type' => 'select',
                'options' => [static::class, 'getThemePageOptions'],
                'validationRule' => 'required|regex:/^[a-z0-9\-_\.]+$/i',
            ],
            'successPage' => [
                'label' => 'Page to redirect to when checkout is successful',
                'type' => 'select',
                'options' => [static::class, 'getThemePageOptions'],
                'validationRule' => 'required|regex:/^[a-z0-9\-_\.]+$/i',
            ],
        ];
    }

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

        if ($this->isTwoPageCheckout && $this->checkoutStep !== self::STEP_PAY) {
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

        throw_if(!$payment, ValidationException::withMessages([
            'form.payment' => lang('igniter.cart::default.checkout.error_invalid_payment'),
        ]));

        throw_if(!$payment->paymentProfileExists($customer), ValidationException::withMessages([
            'form.payment' => lang('igniter.cart::default.checkout.error_payment_profile_not_found'),
        ]));

        $payment->deletePaymentProfile($customer);

        return redirect()->back();
    }

    protected function getOrder()
    {
        if (!is_null($this->order)) {
            return $this->order;
        }

        return $this->order = $this->orderManager->loadOrder();
    }

    protected function checkCheckoutSecurity()
    {
        try {
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

            Event::dispatch('igniter.orange.checkCheckoutSecurity', [$this]);
        } catch (Exception $ex) {
            flash()->warning($ex->getMessage())->now();

            return true;
        }
    }

    protected function validateCheckout(Order $order)
    {
        $this->form->requiresAddress = $order->isDeliveryType();
        $this->form->telephoneIsRequired = $this->telephoneIsRequired;

        $this->form->withValidator(function($validator) use ($order) {
            $validator->after(function($validator) use ($order) {
                if ($order->isDeliveryType()) {
                    rescue(function() {
                        $this->orderManager->validateDeliveryAddress($this->form->toArray());
                    }, function(\Exception $ex) use ($validator) {
                        $validator->errors()->add('address_1', $ex->getMessage());
                    });
                }

                if ($this->form->payment && !$this->orderManager->getPayment($this->form->payment)) {
                    $validator->errors()->add('payment', lang('igniter.cart::default.checkout.error_invalid_payment'));
                }
            });
        });

        $data = $this->form->validate();
        $data = array_merge(array_pull($data, 'payment_fields', []), $data);

        $this->orderManager->applyCurrentPaymentFee($this->form->payment);

        Event::dispatch('igniter.orange.validateCheckout', [$data, $order]);

        return $data;
    }

    protected function isOrderMarkedAsProcessed()
    {
        $order = $this->getOrder();
        if (!$order->isPaymentProcessed()) {
            return false;
        }

        return $this->redirect($order->getUrl($this->successPage));
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
