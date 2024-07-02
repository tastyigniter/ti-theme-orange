<?php

namespace Igniter\Orange\Livewire\Forms;

use Livewire\Form;

class AddressBookForm extends Form
{
    public ?string $address_id;

    public ?string $address_1;

    public ?string $address_2;

    public ?string $city;

    public ?string $state;

    public ?string $postcode;

    public ?string $country_id;

    public bool $is_default = false;

    public function validationAttributes()
    {
        return [
            'address_id' => lang('igniter.user::default.account.label_address_id'),
            'address_1' => lang('igniter.user::default.account.label_address_1'),
            'address_2' => lang('igniter.user::default.account.label_address_2'),
            'city' => lang('igniter.user::default.account.label_city'),
            'state' => lang('igniter.user::default.account.label_state'),
            'postcode' => lang('igniter.user::default.account.label_postcode'),
            'country_id' => lang('igniter.user::default.account.label_country'),
            'is_default' => lang('igniter.user::default.text_set_default'),
        ];
    }

    public function rules()
    {
        return [
            'address_id' => 'nullable|integer',
            'address_1' => 'required|min:3|max:128',
            'address_2' => 'max:128',
            'city' => 'required|min:2|max:128',
            'state' => 'max:128',
            'postcode' => 'min:2|max:11',
            'country_id' => 'required|integer',
            'is_default' => 'boolean',
        ];
    }

    public function fillFrom($address, $defaultAddressId = null)
    {
        $this->address_id = $address?->address_id;
        $this->address_1 = $address?->address_1;
        $this->address_2 = $address?->address_2;
        $this->city = $address?->city;
        $this->state = $address?->state;
        $this->postcode = $address?->postcode;
        $this->country_id = $address?->country_id;
        $this->is_default = $address->address_id == $defaultAddressId;
    }
}
