<?php

namespace Igniter\Orange\Tests\Livewire;

use Igniter\Orange\Livewire\AddressBook;
use Igniter\System\Models\Country;
use Igniter\User\Models\Address;
use Igniter\User\Models\Customer;
use Livewire\Livewire;

beforeEach(function() {
    $this->address = Address::factory()->create();
    $this->customer = Customer::factory()
        ->for($this->address)
        ->create([
            'first_name' => 'Test',
            'last_name' => 'User',
        ]);

    $this->address->customer_id = $this->customer->getKey();
    $this->address->save();
});

it('mounts correctly', function() {
    Livewire::actingAs($this->customer, 'igniter-customer')
        ->test(AddressBook::class)
        ->assertSet('defaultAddressId', $this->address->getKey())
        ->assertSet('form.country_id', Country::getDefaultKey());
});

it('updates address id correctly', function() {
    Livewire::actingAs($this->customer, 'igniter-customer')
        ->test(AddressBook::class)
        ->assertSet('addressId', null)
        ->assertSet('showModal', false)
        ->set('addressId', 1)
        ->assertSet('showModal', true);
});

it('saves address correctly', function() {
    Livewire::actingAs($this->customer, 'igniter-customer')
        ->test(AddressBook::class)
        ->set('addressId', $this->address->getKey())
        ->set('form.address_1', '123 Test St')
        ->set('form.city', 'Test city')
        ->set('form.country_id', 123)
        ->set('form.postcode', 'postcode')
        ->call('onSave')
        ->assertSet('addressId', null)
        ->assertSet('showModal', false);
});

it('sets default address correctly', function() {
    $address = Address::factory()->for($this->customer)->create();
    Livewire::actingAs($this->customer, 'igniter-customer')
        ->test(AddressBook::class)
        ->call('onSetDefault', $address->getKey())
        ->assertSet('defaultAddressId', $address->getKey());
});

it('deletes address correctly', function() {
    $address = Address::factory()->for($this->customer)->create();
    Livewire::actingAs($this->customer, 'igniter-customer')
        ->test(AddressBook::class)
        ->call('onDelete', $address->getKey())
        ->assertSet('addressId', null);
});
