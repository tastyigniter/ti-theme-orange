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

    public ?string $address_1 = null;

    public ?string $address_2 = null;

    public ?string $city = null;

    public ?string $state = null;

    public ?string $postcode = null;

    public ?string $country_id = null;

    public ?string $payment = null;

    public array $payment_fields = [];

    public bool $termsAgreed = false;

    public ?bool $requiresAddress = null;

    public bool $telephoneIsRequired = true;

    public function validationAttributes()
    {
        return [
            'firstName' => lang('igniter.cart::default.checkout.label_first_name'),
            'lastName' => lang('igniter.cart::default.checkout.label_last_name'),
            'email' => lang('igniter.cart::default.checkout.label_email'),
            'telephone' => lang('igniter.cart::default.checkout.label_telephone'),
            'comment' => lang('igniter.cart::default.checkout.label_comment'),
            'deliveryComment' => lang('igniter.cart::default.checkout.label_delivery_comment'),
            'address_id' => lang('igniter.cart::default.checkout.label_address_id'),
            'address_1' => lang('igniter.cart::default.checkout.label_address_1'),
            'address_2' => lang('igniter.cart::default.checkout.label_address_2'),
            'city' => lang('igniter.cart::default.checkout.label_city'),
            'state' => lang('igniter.cart::default.checkout.label_state'),
            'country_id' => lang('igniter.cart::default.checkout.label_country'),
            'postcode' => lang('igniter.cart::default.checkout.label_postcode'),
            'payment' => lang('igniter.cart::default.checkout.label_payment_method'),
            'termsAgreed' => lang('igniter.cart::default.checkout.text_checkout_terms'),
        ];
    }

    public function rules()
    {
        return [
            'first_name' => ['required', 'between:1,48'],
            'last_name' => ['required', 'between:1,48'],
            'email' => ['sometimes', 'required', 'email:filter', 'max:96', Rule::unique('customers', 'email')->ignore(Auth::customer()?->getKey(), 'customer_id')],
            'telephone' => ['sometimes', $this->telephoneIsRequired ? 'required' : '', 'regex:/^([0-9\s\-\+\(\)]*)$/i'],
            'comment' => ['max:500'],
            'delivery_comment' => ['max:500'],
            'address_id' => ['exclude_unless:requiresAddress,true', 'nullable', 'integer'],
            'address_1' => ['exclude_unless:requiresAddress,true', 'required', 'min:3', 'max:128'],
            'address_2' => ['exclude_unless:requiresAddress,true', 'nullable', 'min:3', 'max:128'],
            'city' => ['exclude_unless:requiresAddress,true', 'nullable', 'min:2', 'max:128'],
            'state' => ['exclude_unless:requiresAddress,true', 'nullable', 'max:128'],
            'postcode' => ['exclude_unless:requiresAddress,true', 'nullable', 'string'],
            'country_id' => ['exclude_unless:requiresAddress,true', 'nullable', 'integer'],
            'payment' => ['nullable', 'alpha_dash'],
            'termsAgreed' => ['accepted'],
            'payment_fields' => ['sometimes', 'array'],
            'payment_fields.*' => ['sometimes'],
            'payment_fields.pay_from_profile' => ['sometimes', 'integer'],
            'payment_fields.create_payment_profile' => ['sometimes', 'integer'],
        ];
    }
}
