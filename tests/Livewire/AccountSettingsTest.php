<?php

use Igniter\Cart\Facades\Cart;
use Igniter\Orange\Livewire\AccountSettings;
use Igniter\User\Facades\Auth;
use Igniter\User\Models\Customer;
use Livewire\Livewire;

beforeEach(function() {
    $this->customer = Customer::factory()->create([
        'first_name' => 'Test',
        'last_name' => 'User',
    ]);
});

it('mounts correctly', function() {
    Livewire::actingAs($this->customer, 'igniter-customer')
        ->test(AccountSettings::class)
        ->assertSet('form.first_name', $this->customer->first_name)
        ->assertSet('form.last_name', $this->customer->last_name)
        ->assertSet('form.telephone', $this->customer->telephone)
        ->assertSet('form.email', $this->customer->email);
});

it('gets cart count correctly', function() {
    Cart::shouldReceive('count')->andReturn(5);

    Livewire::actingAs($this->customer, 'igniter-customer')
        ->test(AccountSettings::class)
        ->call('cartCount')
        ->assertReturned(5);
});

it('gets cart total correctly', function() {
    Cart::shouldReceive('total')->andReturn(100);

    Livewire::actingAs($this->customer, 'igniter-customer')
        ->test(AccountSettings::class)
        ->call('cartTotal')
        ->assertReturned(100);
});

it('updates account settings correctly', function() {
    Livewire::actingAs($this->customer, 'igniter-customer')
        ->test(AccountSettings::class)
        ->set('form.first_name', 'New')
        ->set('form.last_name', 'Name')
        ->call('onUpdate');

    expect($this->customer->first_name)->toBe('New');
});

it('logs out if email is changed', function() {
    Livewire::actingAs($this->customer, 'igniter-customer')
        ->test(AccountSettings::class)
        ->set('form.email', 'new@email.com')
        ->call('onUpdate')
        ->assertRedirect();

    expect(Auth::check())->toBeFalse();

    $this->customer->refresh();
    expect($this->customer->email)->toBe('new@email.com');
});