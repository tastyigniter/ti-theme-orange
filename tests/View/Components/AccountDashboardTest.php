<?php

namespace Igniter\Orange\Tests\View\Components;

use Igniter\Cart\Facades\Cart;
use Igniter\Main\Traits\ConfigurableComponent;
use Igniter\Orange\View\Components\AccountDashboard;
use Igniter\User\Facades\Auth;
use Igniter\User\Models\Address;
use Igniter\User\Models\Customer;

it('initializes customer data correctly', function() {
    $address = mock(Address::class)->makePartial();
    $address->shouldReceive('getKey')->andReturn(1);
    $customer = mock(Customer::class)->makePartial();
    $customer->shouldReceive('getAttribute')->with('full_name')->andReturn('John Doe');
    $customer->shouldReceive('getAttribute')->with('address')->andReturn($address);
    Auth::shouldReceive('getUser')->andReturn($customer);

    $component = new AccountDashboard();

    expect(class_uses_recursive($component))->toContain(ConfigurableComponent::class)
        ->and($component->customerName)->toBe('John Doe')
        ->and($component->hasDefaultAddress)->toBeTrue()
        ->and($component->defaultAddressId)->toBe(1)
        ->and($component->formattedAddress)->toBe(format_address($customer->address));
});

it('handles null customer correctly', function() {
    Auth::shouldReceive('getUser')->andReturn(null);

    $component = new AccountDashboard();

    expect($component->customerName)->toBe('')
        ->and($component->hasDefaultAddress)->toBeFalse()
        ->and($component->defaultAddressId)->toBeNull()
        ->and($component->formattedAddress)->toBe('');
});

it('returns correct cart count', function() {
    Cart::shouldReceive('count')->andReturn(5);

    $component = new AccountDashboard();

    $cartCount = $component->cartCount();

    expect($cartCount)->toBe(5);
});

it('returns correct cart total', function() {
    Cart::shouldReceive('total')->andReturn(100.0);

    $component = new AccountDashboard();

    $cartTotal = $component->cartTotal();

    expect($cartTotal)->toBe(100.0);
});

it('renders view', function() {
    $component = new AccountDashboard();
    $view = $component->render();

    expect($view->getName())->toBe('igniter-orange::components.account-dashboard');
});
