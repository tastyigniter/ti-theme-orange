<?php

use Igniter\Orange\Livewire\ReservationPreview;
use Igniter\Reservation\Models\Reservation;
use Livewire\Livewire;

beforeEach(function() {
    $this->reservation = Reservation::factory()->create([
        'reserve_date' => now()->addDay()->toDateString(),
    ]);
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
