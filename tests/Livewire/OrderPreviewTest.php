<?php

namespace Igniter\Orange\Tests\Livewire;

use Igniter\Cart\Models\Order;
use Igniter\Orange\Livewire\OrderPreview;
use Livewire\Livewire;

beforeEach(function() {
    $this->order = Order::factory()->create();
});

it('mounts and prepare props', function() {
    Livewire::test(OrderPreview::class, ['hash' => $this->order->hash])
        ->assertSet('hashParamName', 'hash')
        ->assertSet('loginPage', 'account.login')
        ->assertSet('ordersPage', 'account.orders')
        ->assertSet('checkoutPage', 'checkout.checkout')
        ->assertSet('menusPage', 'local.menus')
        ->assertSet('hideReorderBtn', true)
        ->assertSet('showCancelButton', true);
});

it('gets status width for progress bars', function() {
    Livewire::test(OrderPreview::class, ['hash' => $this->order->hash])
        ->call('getStatusWidthForProgressBars')
        ->assertReturned([
            'default' => '0',
            'processing' => '0',
            'completed' => '0',
        ]);
});

it('shows cancel button', function() {
    Livewire::test(OrderPreview::class, ['hash' => $this->order->hash])
        ->call('showCancelButton')
        ->assertReturned(true);
});

it('handles reorder', function() {
    Livewire::test(OrderPreview::class, ['hash' => $this->order->hash])
        ->call('onReOrder')
        ->assertRedirect();
});

it('handles cancel order', function() {
    Livewire::test(OrderPreview::class, ['hash' => $this->order->hash])
        ->call('onCancel')
        ->assertHasNoErrors();
});