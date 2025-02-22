<?php

namespace Igniter\Orange\Tests\Livewire;

use Igniter\Flame\Geolite\Facades\Geocoder;
use Igniter\Flame\Geolite\Model\Location as GeoliteLocation;
use Igniter\Local\Facades\Location;
use Igniter\Local\Models\Location as LocationModel;
use Igniter\Local\Models\LocationArea;
use Igniter\Main\Traits\ConfigurableComponent;
use Igniter\Orange\Livewire\Concerns\SearchesNearby;
use Igniter\Orange\Livewire\LocalSearch;
use Igniter\User\Models\Address;
use Igniter\User\Models\Customer;
use Livewire\Livewire;

beforeEach(function() {
    Geocoder::shouldReceive('geocode')->byDefault()->andReturn(collect([
        GeoliteLocation::createFromArray([
            'latitude' => 51.5074,
            'longitude' => 0.1278,
        ]),
    ]));
});

it('initialize component correctly', function() {
    $component = new LocalSearch;

    expect(class_uses_recursive($component))
        ->toContain(ConfigurableComponent::class, SearchesNearby::class)
        ->and($component->hideSearch)->toBeFalse()
        ->and($component->searchQuery)->toBeNull()
        ->and($component->searchPoint)->toBeNull()
        ->and($component->menusPage)->toBe('local.menus')
        ->and($component->deliveryAddress)->toBeNull()
        ->and($component->savedAddressId)->toBeNull();
});

it('returns correct component meta', function() {
    $meta = LocalSearch::componentMeta();

    expect($meta['code'])->toBe('igniter-orange::local-search')
        ->and($meta['name'])->toBe('igniter.orange::default.component_local_search_title')
        ->and($meta['description'])->toBe('igniter.orange::default.component_local_search_desc');
});

it('defines properties correctly', function() {
    $component = new LocalSearch;
    $properties = $component->defineProperties();

    expect(array_keys($properties))->toContain('hideSearch', 'menusPage');
});

it('onSearchNearby errors when geocode returns empty result', function() {
    Geocoder::shouldReceive('geocode')->with('invalid address')->andReturn(collect());
    Geocoder::shouldReceive('getLogs')->andReturn([]);

    Livewire::test(LocalSearch::class)
        ->set('searchQuery', 'invalid address')
        ->call('onSearchNearby')
        ->assertHasErrors(['searchQuery' => [lang('igniter.local::default.alert_invalid_search_query')]]);
});

it('onSearchNearby errors when on invalid search point', function() {
    Livewire::test(LocalSearch::class)
        ->set('searchPoint', ['', ''])
        ->call('onSearchNearby')
        ->assertHasErrors(['searchQuery' => [lang('igniter.local::default.alert_no_search_query')]]);
});

it('onSearchNearby errors when geocode returns invalid coordinates', function() {
    Geocoder::shouldReceive('geocode')->with('123 Main St')->andReturn(collect([
        GeoliteLocation::createFromArray([]),
    ]));

    Livewire::test(LocalSearch::class)
        ->set('searchQuery', '123 Main St')
        ->call('onSearchNearby')
        ->assertHasErrors(['searchQuery' => [lang('igniter.local::default.alert_invalid_search_query')]]);
});

it('onSearchNearby errors when on reverse geocode returns empty results', function() {
    Geocoder::shouldReceive('reverse')->with(500, 500)->andReturn(collect());
    Geocoder::shouldReceive('getLogs')->andReturn([]);

    Livewire::test(LocalSearch::class)
        ->set('searchPoint', [500, 500])
        ->call('onSearchNearby')
        ->assertHasErrors(['searchQuery' => [lang('igniter.local::default.alert_invalid_search_query')]]);
});

it('onSearchNearby errors when on reverse geocode returns invalid coordinates', function() {
    Geocoder::shouldReceive('reverse')->with(500, 500)->andReturn(collect([
        GeoliteLocation::createFromArray([]),
    ]));

    Livewire::test(LocalSearch::class)
        ->set('searchPoint', [500, 500])
        ->call('onSearchNearby')
        ->assertHasErrors(['searchQuery' => [lang('igniter.local::default.alert_invalid_search_query')]]);
});

it('onSearchNearby errors when no nearby location area is found', function() {
    $location = LocationModel::factory()->create();
    Location::setModel($location);
    Geocoder::shouldReceive('geocode')->with('123 Main St')->andReturn(collect([
        GeoliteLocation::createFromArray([
            'latitude' => 51.50987615,
            'longitude' => -0.1446716,
        ]),
    ]));

    Livewire::test(LocalSearch::class)
        ->set('searchQuery', '123 Main St')
        ->call('onSearchNearby')
        ->assertHasErrors(['searchQuery' => [lang('igniter.local::default.alert_no_found_restaurant')]]);
});

it('onSearchNearby searches nearby location', function() {
    $location = LocationModel::factory()->create();
    Location::setModel($location);
    $area = LocationArea::factory()->create([
        'type' => 'polygon',
        'conditions' => ['min_total' => 20],
        'boundaries' => ['vertices' => '[{"lat":51.525998393642936,"lng":-0.13086516710191232},{"lat":51.506999160557775,"lng":-0.13052184434800607},{"lat":51.50651835413632,"lng":-0.17409930227410442},{"lat":51.526225344669776,"lng":-0.17351994512688762}]'],
    ]);
    $location->delivery_areas()->save($area);
    Geocoder::shouldReceive('geocode')->with('123 Main St')->andReturn(collect([
        GeoliteLocation::createFromArray([
            'latitude' => 51.50987615,
            'longitude' => -0.1446716,
        ]),
    ]));

    Livewire::test(LocalSearch::class)
        ->set('searchQuery', '123 Main St')
        ->call('onSearchNearby')
        ->assertRedirect(restaurant_url('local.menus'));
});

it('onSelectAddress errors when missing saved address', function() {
    $customer = Customer::factory()->create();

    Livewire::actingAs($customer, 'igniter-customer')
        ->test(LocalSearch::class)
        ->call('onSelectAddress', 1)
        ->assertHasErrors(['savedAddress' => [lang('igniter.orange::default.alert_saved_address_not_found')]]);
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
        ->test(LocalSearch::class)
        ->call('onSelectAddress', $address->getKey())
        ->assertRedirect(restaurant_url('local.menus'));
});

it('onUserPositionUpdated errors when no search query or point', function() {
    Livewire::test(LocalSearch::class)
        ->call('onUserPositionUpdated', ['', ''])
        ->assertHasErrors(['searchQuery' => [lang('igniter.local::default.alert_no_search_query')]]);
});

it('onUserPositionUpdated updates user position in session correctly', function() {
    Geocoder::shouldReceive('reverse')->with(51.50987615, -0.1446716)->andReturn(collect([
        GeoliteLocation::createFromArray([
            'streetNumber' => '123',
            'streetName' => 'Main St',
            'latitude' => 51.50987615,
            'longitude' => -0.1446716,
        ]),
    ]));

    Livewire::test(LocalSearch::class)
        ->call('onUserPositionUpdated', [51.50987615, -0.1446716])
        ->assertSet('searchQuery', '123 Main St  ');
});

it('onUpdateSearchQuery errors when no search query or point', function() {
    Livewire::test(LocalSearch::class)
        ->set('searchQuery', '')
        ->call('onUpdateSearchQuery')
        ->assertHasErrors(['searchQuery' => [lang('igniter.local::default.alert_no_search_query')]]);
});

it('onUpdateSearchQuery updates user position in session correctly', function() {
    $location = LocationModel::factory()->create();
    Location::setModel($location);
    Geocoder::shouldReceive('geocode')->with('123 Main St')->andReturn(collect([
        GeoliteLocation::createFromArray([
            'latitude' => 51.50987615,
            'longitude' => -0.1446716,
        ]),
    ]));

    Livewire::test(LocalSearch::class)
        ->set('searchQuery', '123 Main St')
        ->call('onUpdateSearchQuery')
        ->assertRedirect();

    expect(Location::getSession('searchQuery'))->toBe('123 Main St')
        ->and(Location::getSession('position')->getCoordinates()->getLatitude())->toBe(51.50987615)
        ->and(Location::getSession('position')->getCoordinates()->getLongitude())->toBe(-0.1446716);
});
