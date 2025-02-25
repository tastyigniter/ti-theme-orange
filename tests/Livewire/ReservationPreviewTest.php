<?php

declare(strict_types=1);

use Igniter\Main\Traits\ConfigurableComponent;
use Igniter\Orange\Livewire\ReservationPreview;
use Igniter\Reservation\Models\Reservation;
use Livewire\Livewire;

beforeEach(function(): void {
    $this->reservation = Reservation::factory()->create([
        'reserve_date' => now()->addDay()->toDateString(),
    ]);
});

it('initialize component correctly', function(): void {
    $component = new ReservationPreview;

    expect(class_uses_recursive($component))
        ->toContain(ConfigurableComponent::class)
        ->and($component->hashParamName)->toBe('hash')
        ->and($component->hash)->toBeNull()
        ->and($component->showCancelButton)->toBeFalse();
});

it('returns correct component meta', function(): void {
    $meta = ReservationPreview::componentMeta();

    expect($meta['code'])->toBe('igniter-orange::reservation-preview')
        ->and($meta['name'])->toBe('igniter.orange::default.component_reservation_preview_title')
        ->and($meta['description'])->toBe('igniter.orange::default.component_reservation_preview_desc');
});

it('defines properties correctly', function(): void {
    $component = new ReservationPreview;
    $properties = $component->defineProperties();

    expect(array_keys($properties))->toContain('hashParamName');
});

it('mounts and prepares props', function(): void {
    Livewire::test(ReservationPreview::class, ['hash' => $this->reservation->hash])
        ->assertSet('hashParamName', 'hash')
        ->assertSet('showCancelButton', false);
});

it('cancels reservation', function(): void {
    $this->reservation->location->settings()->create([
        'item' => 'booking',
        'data' => ['cancellation_timeout' => '15'],
    ]);

    Livewire::test(ReservationPreview::class, ['hash' => $this->reservation->hash])
        ->call('onCancel')
        ->assertHasNoErrors();
});
