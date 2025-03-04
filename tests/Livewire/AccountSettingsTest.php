<?php

declare(strict_types=1);

use Igniter\Cart\Facades\Cart;
use Igniter\Main\Traits\ConfigurableComponent;
use Igniter\Orange\Livewire\AccountSettings;
use Igniter\User\Facades\Auth;
use Igniter\User\Models\Customer;
use Livewire\Livewire;

beforeEach(function(): void {
    $this->customer = Customer::factory()->create([
        'first_name' => 'Test',
        'last_name' => 'User',
    ]);
});

it('initialize component correctly', function(): void {
    $component = new AccountSettings;

    expect(class_uses_recursive($component))
        ->toContain(ConfigurableComponent::class)
        ->and($component->loginPage)->toBe('account.login');
});

it('returns correct component meta', function(): void {
    $meta = AccountSettings::componentMeta();

    expect($meta['code'])->toBe('igniter-orange::account-settings')
        ->and($meta['name'])->toBe('igniter.orange::default.component_account_settings_title')
        ->and($meta['description'])->toBe('igniter.orange::default.component_account_settings_desc');
});

it('defines properties correctly', function(): void {
    $component = new AccountSettings;
    $properties = $component->defineProperties();

    expect($properties['loginPage']['label'])->toBe('Login page')
        ->and($properties['loginPage']['type'])->toBe('select')
        ->and($properties['loginPage']['options'])->toBe([AccountSettings::class, 'getThemePageOptions']);
});

it('mounts correctly', function(): void {
    Livewire::actingAs($this->customer, 'igniter-customer')
        ->test(AccountSettings::class)
        ->assertSet('form.first_name', $this->customer->first_name)
        ->assertSet('form.last_name', $this->customer->last_name)
        ->assertSet('form.telephone', $this->customer->telephone)
        ->assertSet('form.email', $this->customer->email);
});

it('gets cart count correctly', function(): void {
    Cart::shouldReceive('count')->andReturn(5);

    Livewire::actingAs($this->customer, 'igniter-customer')
        ->test(AccountSettings::class)
        ->call('cartCount')
        ->assertReturned(5);
});

it('gets cart total correctly', function(): void {
    Cart::shouldReceive('total')->andReturn(100);

    Livewire::actingAs($this->customer, 'igniter-customer')
        ->test(AccountSettings::class)
        ->call('cartTotal')
        ->assertReturned(100);
});

it('updates account settings correctly', function(): void {
    Livewire::actingAs($this->customer, 'igniter-customer')
        ->test(AccountSettings::class)
        ->set('form.first_name', 'New')
        ->set('form.last_name', 'Name')
        ->call('onUpdate');

    expect($this->customer->first_name)->toBe('New');
});

it('logs out if email is changed', function(): void {
    Livewire::actingAs($this->customer, 'igniter-customer')
        ->test(AccountSettings::class)
        ->set('form.email', 'new@email.com')
        ->call('onUpdate')
        ->assertRedirect();

    expect(Auth::check())->toBeFalse();

    $this->customer->refresh();
    expect($this->customer->email)->toBe('new@email.com');
});
