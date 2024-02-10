<?php

namespace Igniter\Orange\Livewire\Forms;

use Igniter\User\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Form;

class CheckoutForm extends Form
{
    public ?string $first_name = null;

    public ?string $last_name = null;

    public ?string $email = null;

    public ?string $telephone = null;

    public ?string $comment = null;

    public ?string $delivery_comment = null;

    public ?string $address_id = null;

    public array $address = [];

    public ?string $payment = null;

    public bool $termsAgreed = false;

    public bool $requiresAddress = false;

    public bool $requiresPayment = false;

    public function validationAttributes()
    {
        return [
            'firstName' => lang('igniter.cart::default.checkout.label_first_name'),
            'lastName' => lang('igniter.cart::default.checkout.label_last_name'),
            'email' => lang('igniter.cart::default.checkout.label_email'),
            'telephone' => lang('igniter.cart::default.checkout.label_telephone'),
            'comment' => lang('igniter.cart::default.checkout.label_comment'),
            'deliveryComment' => lang('igniter.cart::default.checkout.label_delivery_comment'),
            'addressId' => lang('igniter.cart::default.checkout.label_address'),
            'address' => lang('igniter.cart::default.checkout.label_address'),
            'address.address_id' => lang('igniter.cart::default.checkout.label_address_id'),
            'address.address_1' => lang('igniter.cart::default.checkout.label_address_1'),
            'address.address_2' => lang('igniter.cart::default.checkout.label_address_2'),
            'address.city' => lang('igniter.cart::default.checkout.label_city'),
            'address.state' => lang('igniter.cart::default.checkout.label_state'),
            'address.country_id' => lang('igniter.cart::default.checkout.label_country'),
            'address.postcode' => lang('igniter.cart::default.checkout.label_postcode'),
            'payment' => lang('igniter.cart::default.checkout.label_payment_method'),
            'termsAgreed' => lang('igniter.cart::default.checkout.label_checkout_terms'),
        ];
    }

    public function rules()
    {
        return [
            'first_name' => ['required', 'between:1,48'],
            'last_name' => ['required', 'between:1,48'],
            'email' => ['sometimes', 'required', 'email:filter', 'max:96', Rule::unique('customers', 'email')->ignore(Auth::customer()?->getKey(), 'customer_id')],
            'telephone' => ['sometimes', 'required', 'regex:/^([0-9\s\-\+\(\)]*)$/i'],
            'comment' => ['max:500'],
            'delivery_comment' => ['max:500'],
            'address_id' => ['exclude_unless:form.requiresAddress,true', 'nullable', 'integer'],
            'address' => ['exclude_unless:form.requiresAddress,true', 'array'],
            'address.address_id' => ['exclude_unless:form.requiresAddress,true', 'integer'],
            'address.address_1' => ['exclude_unless:form.requiresAddress,true', 'required', 'min:3', 'max:128'],
            'address.address_2' => ['exclude_unless:form.requiresAddress,true', 'nullable', 'min:3', 'max:128'],
            'address.city' => ['exclude_unless:form.requiresAddress,true', 'nullable', 'min:2', 'max:128'],
            'address.state' => ['exclude_unless:form.requiresAddress,true', 'nullable', 'max:128'],
            'address.country_id' => ['exclude_unless:form.requiresAddress,true', 'nullable', 'integer'],
            'address.postcode' => ['exclude_unless:form.requiresAddress,true', 'nullable', 'string'],
            'payment' => ['exclude_unless:form.requiresPayment,true', 'required', 'alpha_dash'],
            'termsAgreed' => ['accepted_if:form.requiresPayment,true'],
        ];
    }
}
