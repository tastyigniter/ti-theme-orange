<?php

namespace Igniter\Orange\Tests\Livewire;

use Igniter\Admin\Classes\FormField;
use Igniter\Admin\Widgets\Form;
use Igniter\Main\Http\Controllers\Themes;
use Igniter\Main\Models\Theme;
use Igniter\Main\Traits\ConfigurableComponent;
use Igniter\Main\Traits\UsesPage;
use Igniter\Orange\Livewire\ReservationList;
use Igniter\User\Models\Customer;
use Livewire\Livewire;
use Livewire\WithPagination;

it('initialize component correctly', function() {
    $component = new ReservationList;

    expect(class_uses_recursive($component))
        ->toContain(ConfigurableComponent::class, UsesPage::class, WithPagination::class)
        ->and($component->itemsPerPage)->toBe(20)
        ->and($component->sortOrder)->toBe('reserve_date desc')
        ->and($component->reservationPage)->toBe('account.reservation');
});

it('returns correct component meta', function() {
    $meta = ReservationList::componentMeta();

    expect($meta['code'])->toBe('igniter-orange::reservation-list')
        ->and($meta['name'])->toBe('igniter.orange::default.component_reservation_list_title')
        ->and($meta['description'])->toBe('igniter.orange::default.component_reservation_list_desc');
});

it('defines properties correctly', function() {
    $component = new ReservationList;
    $properties = $component->defineProperties();

    expect(array_keys($properties))->toContain(
        'itemsPerPage',
        'sortOrder',
        'reservationPage',
    );
});

it('returns correct sorted order options', function() {
    $form = new Form(resolve(Themes::class), [
        'model' => new Theme,
    ]);
    $field = new FormField('sortOrder', 'Sort Order');
    $field->displayAs('select', [
        'property' => 'sortOrder',
    ]);

    $options = ReservationList::getPropertyOptions($form, $field);

    expect($options)->toBeArray()->not->toBeEmpty();
});

it('returns empty array for unknown property', function() {
    $form = new Form(resolve(Themes::class), [
        'model' => new Theme,
    ]);
    $field = new FormField('unknown', 'Unknown');
    $field->displayAs('select', [
        'property' => 'unknown',
    ]);

    $options = ReservationList::getPropertyOptions($form, $field);

    expect($options)->toBeArray()->toBeEmpty();
});

it('mounts and loads reservations', function() {
    $customer = Customer::factory()->hasReservations(5)->create();

    Livewire::actingAs($customer, 'igniter-customer')
        ->test(ReservationList::class)
        ->assertViewHas('allowReviews', 20)
        ->assertViewHas('reservations', function($reservations) {
            return $reservations->count() === 5;
        });
});

it('loads empty reservations when customer is not authenticated', function() {
    Livewire::test(ReservationList::class)
        ->assertViewHas('reservations', [])
        ->assertViewHas('allowReviews', 20);
});

