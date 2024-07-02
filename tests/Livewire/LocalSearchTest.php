<?php

namespace Igniter\Orange\Tests\Livewire;

use Igniter\Flame\Geolite\Facades\Geocoder;
use Igniter\Flame\Geolite\Model\Location as GeoliteLocation;
use Igniter\Orange\Livewire\LocalSearch;
use Igniter\User\Models\Address;
use Igniter\User\Models\Customer;
use Livewire\Livewire;

beforeEach(function() {
    Geocoder::shouldReceive('geocode')->andReturn(collect([
        GeoliteLocation::createFromArray([
            'latitude' => 51.5074,
            'longitude' => 0.1278,
        ]),
    ]));
});

it('fails when searching nearby location', function() {
    Livewire::test(LocalSearch::class)
        ->set('searchQuery', '123 Main St')
        ->call('onSearchNearby')
        ->assertHasErrors(['searchQuery']);
});

it('fails with an outside delivery area previously saved address', function() {
    $customer = Customer::factory()->create();
    $address = Address::factory()->create([
        'customer_id' => $customer->getKey(),
    ]);

    Livewire::actingAs($customer, 'igniter-customer')
        ->test(LocalSearch::class)
        ->call('onSelectAddress', $address->getKey())
        ->assertHasErrors(['savedAddress']);
});
