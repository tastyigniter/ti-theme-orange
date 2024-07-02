<?php

namespace Igniter\Orange\Tests\Livewire;

use Igniter\Cart\Classes\AbstractOrderType;
use Igniter\Cart\Classes\CartManager;
use Igniter\Cart\Classes\OrderManager;
use Igniter\Cart\Models\Order;
use Igniter\Local\Facades\Location;
use Igniter\Orange\Livewire\Checkout;
use Livewire\Livewire;

beforeEach(function() {
    $this->order = Order::factory()->create();

    $this->orderManagerMock = $this->mock(OrderManager::class);
    $this->cartManagerMock = $this->mock(CartManager::class);

    $this->orderManagerMock->shouldReceive('loadOrder')->andReturn($this->order);
    $this->orderManagerMock->shouldReceive('validateCustomer')->andReturnNull();
    $this->orderManagerMock->shouldReceive('findDeliveryAddress')->andReturnNull();
    $this->orderManagerMock->shouldReceive('getPaymentGateways')->andReturn(collect());

    $this->cartManagerMock->shouldReceive('validateContents')->once()->andReturnNull();
    $this->cartManagerMock->shouldReceive('validateLocation')->once()->andReturnNull();
    $this->cartManagerMock->shouldReceive('validateOrderTime')->once()->andReturnNull();
    $this->cartManagerMock->shouldReceive('cartTotalIsBelowMinimumOrder')->once()->andReturnFalse();
    $this->cartManagerMock->shouldReceive('deliveryChargeIsUnavailable')->once()->andReturnFalse();

    $orderTypeMock = $this->mock(AbstractOrderType::class);
    Location::shouldReceive('current')->andReturn($this->order->location);
    Location::shouldReceive('getOrderTypes->get')->andReturn($orderTypeMock);
    Location::shouldReceive('getOrderType')->andReturn($orderTypeMock);
    Location::shouldReceive('orderTimeIsAsap')->andReturnTrue();
    Location::shouldReceive('userPosition')->andReturnNull();
    Location::shouldReceive('orderDateTime')->andReturnTrue();
});

it('can mount and prepare props', function() {
    Livewire::test(Checkout::class)
        ->assertSet('isTwoPageCheckout', false)
        ->assertSet('showAddress2Field', true)
        ->assertSet('showCityField', true)
        ->assertSet('showStateField', true)
        ->assertSet('showCountryField', false)
        ->assertSet('showPostcodeField', true)
        ->assertSet('showTelephoneField', true)
        ->assertSet('showCommentField', true)
        ->assertSet('showDeliveryCommentField', true)
        ->assertSet('telephoneIsRequired', true)
        ->assertSet('agreeTermsSlug', 'terms-and-conditions')
        ->assertSet('menusPage', 'local.menus')
        ->assertSet('checkoutPage', 'checkout.checkout')
        ->assertSet('successPage', 'checkout.success')
        ->assertSet('checkoutStep', 'details');
})->skip('failing from nested blade components');

it('can validate checkout')->todo();

it('can confirm checkout')->todo();

it('can choose payment')->todo();

it('can delete payment profile')->todo();
