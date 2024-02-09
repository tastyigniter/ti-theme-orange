<?php

namespace Igniter\Orange\Livewire\Pages;

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
use Illuminate\Support\Facades\Redirect;
use Livewire\Attributes\Computed;
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
    public string $agreeTermsSlug = '';

    /** The checkout page */
    public string $menusPage = 'local'.DIRECTORY_SEPARATOR.'menus';

    /** The checkout page */
    public string $checkoutPage = 'checkout'.DIRECTORY_SEPARATOR.'checkout';

    /** Page to redirect to when checkout is successful */
    public string $successPage = 'checkout'.DIRECTORY_SEPARATOR.'success';

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
     * @var  \Igniter\Cart\Models\Order
     */
    protected $order;

    public function render()
    {
        return view('igniter-orange::livewire.pages.checkout', [
            'customer' => Auth::customer(),
            'order' => $order = $this->getOrder(),
            'locationCurrent' => Location::current(),
            'locationOrderType' => Location::getOrderTypes()->get($order->order_type),
        ]);
    }

    public function mount()
    {
        //        if ($redirect = $this->isOrderMarkedAsProcessed()) {
        //            return $redirect;
        //        }
        //
        //        if ($this->checkCheckoutSecurity()) {
        //            return $this->redirect(restaurant_url($this->menusPage), navigate: true);
        //        }

        Assets::addJs('js/checkout.js', 'checkout-js');

        foreach ($this->paymentGateways as $paymentGateway) {
            $paymentGateway->beforeRenderPaymentForm($paymentGateway, controller());
        }

        $order = $this->getOrder();
        $this->form->firstName = $order->first_name;
        $this->form->lastName = $order->last_name;
        $this->form->email = $order->email;
        $this->form->telephone = $order->telephone;
        $this->form->comment = $order->comment;
        $this->form->deliveryComment = $order->delivery_comment;
        $this->form->addressId = $order->address_id;
        $this->form->payment = $order->payment;
        $this->form->address = $order->address?->toArray();
    }

    public function boot()
    {
        $this->orderManager = resolve(OrderManager::class);
        $this->cartManager = resolve(CartManager::class);

        //        $this->checkoutStep = $this->param($this->property('stepParamName'), 'details');
    }

    public function updating($property, $value)
    {
        if ($property === 'form.addressId' && is_numeric($value)) {
            $this->form->address = $this->customerAddresses->firstWhere('address_id', $value)?->toArray();
        }

        if ($property === 'form.payment' && strlen($value)) {
            throw_unless($payment = $this->orderManager->getPayment($value), new ApplicationException(
                lang('igniter.cart::default.checkout.error_invalid_payment')
            ));

            $this->form->payment = $value;
            $this->orderManager->applyCurrentPaymentFee($payment->code);
        }
    }

    #[Computed]
    public function customerAddresses()
    {
        return $this->getOrder()->listCustomerAddresses();
    }

    #[Computed]
    public function paymentGateways()
    {
        return $this->getOrder()?->order_total > 0
            ? $this->orderManager->getPaymentGateways()
            : collect();
    }

    public function paymentFormViewName(string $paymentCode)
    {
        throw_unless($paymentMethod = $this->paymentGateways->firstWhere('code', $paymentCode),
            new ApplicationException(lang('igniter.cart::default.checkout.error_invalid_payment'))
        );

        $paymentMethod->beforeRenderPaymentForm($paymentMethod, controller());

        $partialName = strtolower(str_before($paymentMethod->class_name, '\\').'.'.str_before(str_after($paymentMethod->class_name, '\\'), '\\'));
        $partialName .= '::payregister.'.$paymentMethod->code;

        return view()->exists($partialName) ? $partialName : null;
    }

    public function getOrder()
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

    public function onConfirm()
    {
        if ($redirect = $this->isOrderMarkedAsProcessed()) {
            return $redirect;
        }

        $this->validateCheckoutSecurity();

        $this->prepareDeliveryAddress();

        $data = $this->form->validate();

        $data['cancelPage'] = $this->checkoutPage;
        $data['successPage'] = $this->successPage;

        try {
            $order = $this->getOrder();

            $this->validateCheckout($order, $data);

            $this->orderManager->saveOrder($order, $data);

            if (!$this->canConfirmCheckout()) {
                return redirect()->to(Livewire::originalUrl().'?step=pay');
            }

            if (($redirect = $this->orderManager->processPayment($order, $data)) === false) {
                return;
            }

            if ($redirect instanceof RedirectResponse) {
                return $redirect;
            }

            if ($redirect = $this->isOrderMarkedAsProcessed()) {
                return $redirect;
            }
        } catch (Exception $ex) {
            flash()->warning($ex->getMessage())->important();

            return Redirect::back()->withInput();
        }
    }

    public function onDeletePaymentProfile()
    {
        $customer = Auth::customer();
        $payment = $this->orderManager->getPayment(post('code'));

        if (!$payment || !$payment->paymentProfileExists($customer)) {
            throw new ApplicationException(lang('igniter.cart::default.checkout.error_invalid_payment'));
        }

        $payment->deletePaymentProfile($customer);

        $this->controller->pageCycle();

        $result = $this->fetchPartials();

        if ($cartBox = $this->controller->findComponentByAlias($this->property('cartBoxAlias'))) {
            $result = array_merge($result, $cartBox->fetchPartials());
        }

        return $result;
    }

    protected function checkCheckoutSecurity()
    {
        try {
            $this->fireSystemEvent('igniter.cart.beforeCheckCheckoutSecurity', [$this]);

            $this->validateCheckoutSecurity();

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

    protected function validateCheckoutSecurity()
    {
        $this->cartManager->validateContents();

        $this->orderManager->validateCustomer(Auth::getUser());

        $this->cartManager->validateLocation();

        $this->cartManager->validateOrderTime();
    }

    protected function validateCheckout(Order $order, $data)
    {
        if ($this->checkoutStep === 'details' && $order->isDeliveryType()) {
            $this->orderManager->validateDeliveryAddress($this->form->address);
        }

        if ($this->canConfirmCheckout() && $order->order_total > 0 && !$order->payment) {
            throw new ApplicationException(lang('igniter.cart::default.checkout.error_invalid_payment'));
        }

        Event::fire('igniter.checkout.afterValidate', [$data, $order]);
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
        $addressId = $this->form->addressId;
        if ($addressId && $address = $this->orderManager->findDeliveryAddress($addressId)) {
            $this->form->address = $address->toArray();
        }

        if (!empty($this->form->address) && !isset($this->form->address['country_id'])) {
            $this->form->address['country_id'] = Country::getDefaultKey();
        }
    }

    public function canConfirmCheckout()
    {
        if (!$this->isTwoStepCheckout) {
            return true;
        }

        if ($this->getOrder()?->order_total < 1) {
            return true;
        }

        return $this->checkoutStep === 'pay';
    }
}
