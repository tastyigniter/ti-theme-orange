<?php

namespace Igniter\Orange\Tests\Livewire;

use Igniter\Flame\Geolite\Facades\Geocoder;
use Igniter\Flame\Geolite\Model\Location as GeoliteLocation;
use Igniter\Local\Facades\Location;
use Igniter\Local\Models\Location as LocationModel;
use Igniter\Local\Models\LocationArea;
use Igniter\Orange\Livewire\FulfillmentModal;
use Igniter\User\Models\Address;
use Igniter\User\Models\Customer;
use Livewire\Livewire;

beforeEach(function() {
    $this->location = LocationModel::factory()->create();
    Location::setModel($this->location);

    $this->travelTo(now()->setHour(2));
});

it('returns correct component meta', function() {
    $meta = FulfillmentModal::componentMeta();

    expect($meta['code'])->toBe('igniter-orange::fulfillment-modal')
        ->and($meta['name'])->toBe('igniter.orange::default.component_fulfillment_modal_title')
        ->and($meta['description'])->toBe('igniter.orange::default.component_fulfillment_modal_desc');
});

it('defines properties correctly', function() {
    $component = new FulfillmentModal();
    $properties = $component->defineProperties();

    expect(array_keys($properties))->toContain(
        'menusPage',
        'previewMode',
        'defaultOrderType',
    );
});

it('mounts and prepare props', function() {
    Livewire::test(FulfillmentModal::class)
        ->assertNotSet('timeslotDates', [])
        ->assertNotSet('timeslotTimes', [])
        ->assertSet('orderType', LocationModel::DELIVERY)
        ->assertSet('isAsap', true)
        ->assertSet('orderDate', now()->toDateString())
        ->assertSet('orderTime', now()->format('H:i'))
        ->assertSet('defaultOrderType', LocationModel::DELIVERY)
        ->assertSet('showAddressPicker', false)
        ->assertSet('hideDeliveryAddress', false)
        ->assertSet('previewMode', false)
        ->assertSet('newSearchQuery', null);
});

it('mounts component fails when no current location', function() {
    Location::clearInternalCache();
    Location::shouldReceive('scheduleTimeslot')->andReturn(collect());
    Location::shouldReceive('current')->andReturnNull()->once();
    Location::shouldReceive('orderType')->andReturn(LocationModel::DELIVERY);
    Location::shouldReceive('orderTimeIsAsap')->andReturnTrue();
    Location::shouldReceive('orderDateTime')->andReturn(now());
    Location::shouldReceive('orderTypeIsDelivery')->andReturnFalse();
    Location::shouldReceive('getActiveOrderTypes')->andReturn(collect());
    Location::shouldReceive('getSession')->andReturnNull();

    Livewire::test(FulfillmentModal::class);
});

it('mounts component sets first available order type when default is disabled', function() {
    expect(Location::orderType())->toBe(LocationModel::DELIVERY);

    $this->location->settings()->create([
        'item' => LocationModel::DELIVERY,
        'data' => ['is_enabled' => 0],
    ]);
    $this->location->settings()->create([
        'item' => LocationModel::COLLECTION,
        'data' => ['is_enabled' => 1],
    ]);

    Livewire::test(FulfillmentModal::class);

    expect(Location::orderType())->toBe(LocationModel::COLLECTION);
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
    $area = LocationArea::factory()->create([
        'type' => 'polygon',
        'conditions' => ['min_total' => 20],
        'boundaries' => ['vertices' => '[{"lat":51.525998393642936,"lng":-0.13086516710191232},{"lat":51.506999160557775,"lng":-0.13052184434800607},{"lat":51.50651835413632,"lng":-0.17409930227410442},{"lat":51.526225344669776,"lng":-0.17351994512688762}]'],
    ]);
    $this->location->delivery_areas()->save($area);
    Geocoder::shouldReceive('geocode')->andReturn(collect([
        GeoliteLocation::createFromArray([
            'latitude' => 51.50987615,
            'longitude' => -0.1446716,
        ]),
    ]));

    Livewire::test(FulfillmentModal::class)
        ->set('searchQuery', '123 Main St')
        ->set('showAddressPicker', true)
        ->call('onConfirm')
        ->assertRedirect();
});

it('throws exception when no delivery area are found', function() {
    Geocoder::shouldReceive('geocode')->andReturn(collect([
        GeoliteLocation::createFromArray([
            'latitude' => 51.50987615,
            'longitude' => -0.1446716,
        ]),
    ]));

    Livewire::test(FulfillmentModal::class)
        ->set('searchQuery', '123 Main St')
        ->set('showAddressPicker', true)
        ->call('onConfirm')
        ->assertHasErrors(['searchQuery']);
});

it('onSelectAddress errors when saved address is outside covered area', function() {
    $customer = Customer::factory()->create();
    $address = Address::factory()->create([
        'customer_id' => $customer->getKey(),
    ]);
    $location = LocationModel::factory()->create();
    Location::setModel($location);
    Geocoder::shouldReceive('geocode')->andReturn(collect([
        GeoliteLocation::createFromArray([
            'latitude' => 51.5074,
            'longitude' => 0.1278,
        ]),
    ]));

    Livewire::actingAs($customer, 'igniter-customer')
        ->test(FulfillmentModal::class)
        ->call('onSelectAddress', $address->getKey())
        ->assertHasErrors(['savedAddress' => [lang('igniter.local::default.alert_delivery_area_unavailable')]]);
});

it('onSelectAddress checks saved address is within covered area', function() {
    $customer = Customer::factory()->create();
    $address = Address::factory()->create([
        'customer_id' => $customer->getKey(),
    ]);
    $location = LocationModel::factory()->create();
    Location::setModel($location);
    $area = LocationArea::factory()->create([
        'type' => 'polygon',
        'conditions' => ['min_total' => 20],
        'boundaries' => ['vertices' => '[{"lat":51.525998393642936,"lng":-0.13086516710191232},{"lat":51.506999160557775,"lng":-0.13052184434800607},{"lat":51.50651835413632,"lng":-0.17409930227410442},{"lat":51.526225344669776,"lng":-0.17351994512688762}]'],
    ]);
    $location->delivery_areas()->save($area);
    Geocoder::shouldReceive('geocode')->andReturn(collect([
        GeoliteLocation::createFromArray([
            'latitude' => 51.50987615,
            'longitude' => -0.1446716,
        ]),
    ]));

    Livewire::actingAs($customer, 'igniter-customer')
        ->test(FulfillmentModal::class)
        ->call('onSelectAddress', $address->getKey());

    expect(Location::getSession('searchQuery'))->toBe(format_address($address, false))
        ->and(Location::getSession('area'))->toBe($area->getKey())
        ->and(Location::getSession('position')->getCoordinates()->getLatitude())->toBe(51.50987615)
        ->and(Location::getSession('position')->getCoordinates()->getLongitude())->toBe(-0.1446716);
});
