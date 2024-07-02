<?php

namespace Igniter\Orange\Tests\Livewire;

use Igniter\Flame\Geolite\Facades\Geocoder;
use Igniter\Flame\Geolite\Model\Location as GeoliteLocation;
use Igniter\Local\Facades\Location;
use Igniter\Local\Models\Location as LocationModel;
use Igniter\Orange\Livewire\FulfillmentModal;
use Livewire\Livewire;

beforeEach(function() {
    $this->location = LocationModel::factory()->create();
    Location::setModel($this->location);

    $this->travelTo(now()->setHour(2));
});

it('mounts and prepare props', function() {
    Livewire::test(FulfillmentModal::class)
        ->assertNotSet('timeslotDates', [])
        ->assertNotSet('timeslotTimes', [])
        ->assertSet('orderType', 'delivery')
        ->assertSet('isAsap', true)
        ->assertSet('orderDate', now()->toDateString())
        ->assertSet('orderTime', now()->format('H:i'))
        ->assertSet('defaultOrderType', 'delivery')
        ->assertSet('showAddressPicker', false)
        ->assertSet('hideDeliveryAddress', false)
        ->assertSet('newSearchQuery', null);
});

it('updates order type', function() {
    Livewire::test(FulfillmentModal::class)
        ->assertSet('orderType', LocationModel::DELIVERY)
        ->set('orderType', LocationModel::COLLECTION)
        ->assertSet('orderType', LocationModel::COLLECTION);
});

it('confirms order fulfillment options', function() {
    Livewire::test(FulfillmentModal::class)
        ->set('orderType', 'delivery')
        ->set('isAsap', true)
        ->call('onConfirm')
        ->assertRedirect();
});

it('updates search query', function() {
    Geocoder::shouldReceive('geocode')->andReturn(collect([
        GeoliteLocation::createFromArray([
            'latitude' => 51.5074,
            'longitude' => 0.1278,
        ]),
    ]));

    Livewire::test(FulfillmentModal::class)
        ->set('searchQuery', '123 Main St')
        ->set('showAddressPicker', true)
        ->call('onConfirm')
        ->assertHasErrors(['searchQuery']);
});
