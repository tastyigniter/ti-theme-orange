<?php

use Igniter\Main\Traits\ConfigurableComponent;
use Igniter\Orange\Livewire\ReservationPreview;
use Igniter\Reservation\Models\Reservation;
use Livewire\Livewire;

beforeEach(function() {
    $this->reservation = Reservation::factory()->create([
        'reserve_date' => now()->addDay()->toDateString(),
    ]);
});

it('initialize component correctly', function() {
    $component = new ReservationPreview;

    expect(class_uses_recursive($component))
        ->toContain(ConfigurableComponent::class)
        ->and($component->hashParamName)->toBe('hash')
        ->and($component->hash)->toBeNull()
        ->and($component->showCancelButton)->toBeFalse();
});

it('returns correct component meta', function() {
    $meta = ReservationPreview::componentMeta();

    expect($meta['code'])->toBe('igniter-orange::reservation-preview')
        ->and($meta['name'])->toBe('igniter.orange::default.component_reservation_preview_title')
        ->and($meta['description'])->toBe('igniter.orange::default.component_reservation_preview_desc');
});

it('defines properties correctly', function() {
    $component = new ReservationPreview;
    $properties = $component->defineProperties();

    expect(array_keys($properties))->toContain('hashParamName');
});

it('mounts and prepares props', function() {
    Livewire::test(ReservationPreview::class, ['hash' => $this->reservation->hash])
        ->assertSet('hashParamName', 'hash')
        ->assertSet('showCancelButton', false);
});

it('cancels reservation', function() {
    $this->reservation->location->settings()->create([
        'item' => 'booking',
        'data' => ['cancellation_timeout' => '15'],
    ]);

    Livewire::test(ReservationPreview::class, ['hash' => $this->reservation->hash])
        ->call('onCancel')
        ->assertHasNoErrors();
});
