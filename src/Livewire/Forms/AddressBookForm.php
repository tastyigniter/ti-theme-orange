<?php

namespace Igniter\Orange\Livewire\Forms;

use Igniter\User\Models\Address;
use Livewire\Attributes\Rule;
use Livewire\Form;

class AddressBookForm extends Form
{
    #[Rule('nullable|integer')]
    public string $address_id;

    #[Rule('required|min:3|max:128', as: 'igniter.user::default.account.label_address_1')]
    public string $address_1;

    #[Rule('max:128', as: 'igniter.user::default.account.label_address_2')]
    public string $address_2;

    #[Rule('required|min:2|max:128', as: 'igniter.user::default.account.label_city')]
    public string $city;

    #[Rule('max:128', as: 'igniter.user::default.account.label_state')]
    public string $state;

    #[Rule('min:2|max:11', as: 'igniter.user::default.account.label_postcode')]
    public string $postcode;

    #[Rule('required|integer', as: 'igniter.user::default.account.label_country')]
    public string $country_id;

    public function fill(?Address $address)
    {
        $this->address_id = $address->getKey() ?? null;
        $this->address_1 = $address->address_1 ?? '';
        $this->address_2 = $address->address_2 ?? '';
        $this->city = $address->city ?? '';
        $this->state = $address->state ?? '';
        $this->postcode = $address->postcode ?? '';
        $this->country_id = $address->country_id ?? '';
    }
}
