<?php

namespace Igniter\Orange\Tests\Livewire;

use Igniter\Cart\Classes\AbstractOrderType;
use Igniter\Coupons\Models\Coupon;
use Igniter\Local\Facades\Location;
use Igniter\Local\Models\Location as LocationModel;
use Igniter\Orange\Livewire\CartBox;
use Illuminate\Support\Facades\Event;
use Livewire\Livewire;

beforeEach(function() {
    $location = LocationModel::factory()->create();
    $orderTypeMock = $this->mock(AbstractOrderType::class);
    $orderTypeMock->shouldReceive('getSchedule')->andReturn($location->newWorkingSchedule(LocationModel::DELIVERY, 5));
    $orderTypeMock->shouldReceive('getCode')->andReturn(LocationModel::DELIVERY);
    Location::shouldReceive('getId')->andReturn($location->getKey());
    Location::shouldReceive('current')->andReturn($location);
    Location::shouldReceive('getOrderType')->andReturn($orderTypeMock);
    Location::shouldReceive('checkOrderTime')->andReturnTrue();
    Location::shouldReceive('checkNoOrderTypeAvailable')->andReturnFalse();
    Location::shouldReceive('minimumOrderTotal')->andReturn(0);
});

it('mounts and prepare props', function() {
    Livewire::test(CartBox::class)
        ->assertSet('checkoutPage', 'checkout.checkout')
        ->assertSet('tipAmount', 0)
        ->assertSet('isCustomTip', false)
        ->assertSet('couponCode', null);
});

it('updates tip amount', function() {
    Livewire::test(CartBox::class)
        ->set('tipAmount', 10)
        ->assertSet('tipAmount', 10);
});

it('applies coupon', function() {
    Event::fake();

    Coupon::factory()->create([
        'code' => 'TESTCOUPON',
    ]);

    Livewire::test(CartBox::class)
        ->set('couponCode', 'TESTCOUPON')
        ->call('onApplyCoupon')
        ->assertSet('couponCode', 'TESTCOUPON');

    Event::assertDispatched('igniter.cart.beforeApplyCoupon');
});

it('applies tip', function() {
    Livewire::test(CartBox::class)
        ->call('onApplyTip', 10, true)
        ->assertSet('tipAmount', 10)
        ->assertSet('isCustomTip', true);
});

it('removes condition', function() {
    Livewire::test(CartBox::class)
        ->call('onRemoveCondition', 'tip')
        ->assertSet('tipAmount', 0)
        ->assertSet('isCustomTip', false);
});
