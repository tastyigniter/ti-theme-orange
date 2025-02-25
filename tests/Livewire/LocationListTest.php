<?php

declare(strict_types=1);

namespace Igniter\Orange\Tests\Livewire;

use Igniter\Admin\Classes\FormField;
use Igniter\Admin\Widgets\Form;
use Igniter\Cart\Http\Controllers\Menus;
use Igniter\Flame\Geolite\Model\Location as GeoliteLocation;
use Igniter\Local\Facades\Location;
use Igniter\Local\Models\ReviewSettings;
use Igniter\Main\Http\Controllers\Themes;
use Igniter\Main\Models\Theme;
use Igniter\Main\Traits\ConfigurableComponent;
use Igniter\Main\Traits\UsesPage;
use Igniter\Orange\Livewire\Concerns\SearchesNearby;
use Igniter\Orange\Livewire\LocationList;
use Igniter\User\Models\Address;
use Illuminate\Support\Facades\Event;
use Livewire\Livewire;
use Livewire\WithPagination;

it('initialize component correctly', function(): void {
    $component = new LocationList;

    expect(class_uses_recursive($component))
        ->toContain(ConfigurableComponent::class, SearchesNearby::class, UsesPage::class, WithPagination::class)
        ->and($component->distanceUnit)->toBe('mi')
        ->and($component->menusPage)->toBe('local.menus')
        ->and($component->itemPerPage)->toBe(20)
        ->and($component->showThumb)->toBeTrue()
        ->and($component->thumbWidth)->toBe(95)
        ->and($component->thumbHeight)->toBe(80)
        ->and($component->sortBy)->toBe('distance')
        ->and($component->orderType)->toBe('delivery')
        ->and($component->search)->toBe('')
        ->and($component->filter)->toBe([]);
});

it('returns correct component meta', function(): void {
    $meta = LocationList::componentMeta();

    expect($meta['code'])->toBe('igniter-orange::location-list')
        ->and($meta['name'])->toBe('igniter.orange::default.component_location_list_title')
        ->and($meta['description'])->toBe('igniter.orange::default.component_location_list_desc');
});

it('defines properties correctly', function(): void {
    $component = new LocationList;
    $properties = $component->defineProperties();

    expect(array_keys($properties))->toContain(
        'menusPage',
        'itemPerPage',
        'showThumb',
        'thumbWidth',
        'thumbHeight',
        'sortBy',
        'orderType',
    );
});

it('returns correct sorted order options for sortBy', function(): void {
    $form = new Form(resolve(Themes::class), [
        'model' => new Theme,
    ]);
    $field = new FormField('sortOrder', 'Sort Order');
    $field->displayAs('select', [
        'property' => 'sortBy',
    ]);

    $options = LocationList::getPropertyOptions($form, $field);

    expect($options)->toBeArray()->not->toBeEmpty();
});

it('returns correct sorted order options for orderType', function(): void {
    $form = new Form(resolve(Themes::class), [
        'model' => new Theme,
    ]);
    $field = new FormField('orderType', 'Order Type');
    $field->displayAs('select', [
        'property' => 'orderType',
    ]);

    $options = LocationList::getPropertyOptions($form, $field);

    expect($options->isNotEmpty())->toBeTrue();
});

it('returns empty array for unknown property', function(): void {
    $form = new Form(resolve(Menus::class), [
        'model' => new Address,
    ]);
    $field = new FormField('sortOrder', 'Sort Order');
    $field->displayAs('select', [
        'property' => 'unknownProperty',
    ]);

    $options = LocationList::getPropertyOptions($form, $field);

    expect($options)->toBe([]);
});

it('mounts and renders component correctly', function(): void {
    Location::updateUserPosition(GeoliteLocation::createFromArray([
        'latitude' => 51.50987615,
        'longitude' => -0.1446716,
    ]));
    Event::listen('igniter.orange.extendLocationListFilters', fn(): array => [
        'cuisine' => [
            'title' => 'Cuisine',
            'query' => function($query, $value) {
                expect($value)->toBe('nigerian');

                return $query;
            },
        ],
        'orderType' => [
            'title' => 'Order Type',
            'query' => function($query, $value): void {},
        ],
    ]);

    setting()->set('distance_unit', 'km');
    ReviewSettings::set('allow_reviews', 1);

    Livewire::test(LocationList::class)
        ->set('sortBy', 'rating')
        ->set('filter', ['cuisine' => 'nigerian'])
        ->assertSet('distanceUnit', 'km')
        ->assertViewHas('allowReviews', true)
        ->assertViewHas('searchQueryPosition')
        ->assertViewHas('locationsList');
});

it('returns order type options', function(): void {
    Livewire::test(LocationList::class)
        ->assertSet('orderTypes', fn($response) => $response->isNotEmpty());
});

it('returns available sorters', function(): void {
    Event::listen('igniter.orange.extendLocationListSorting', fn(): array => [
        'cuisine' => [
            'name' => 'Cuisine',
            'priority' => 999,
            'condition' => 'asc',
        ],
    ]);

    Livewire::test(LocationList::class)
        ->assertSet('sorters', fn($response): bool => array_keys($response) === ['distance', 'newest', 'rating', 'name', 'cuisine']);
});

it('returns available filter', function(): void {
    Event::listen('igniter.orange.extendLocationListFilters', fn(): array => [
        'invalid' => [
            'title' => 'invalid',
            'query' => 'invalid-callback',
        ],
        'cuisine' => [
            'title' => 'Cuisine',
            'query' => function($query, $value) {
                expect($value)->toBe('nigerian');

                return $query;
            },
        ],
    ]);

    Livewire::test(LocationList::class, ['filter' => ['cuisine' => 'nigerian']])
        ->assertSet('filters', fn($response): bool => array_keys($response) === ['invalid', 'cuisine']);
});
