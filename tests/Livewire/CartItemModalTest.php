<?php

namespace Igniter\Orange\Tests\Livewire;

use Igniter\Cart\Classes\AbstractOrderType;
use Igniter\Cart\Models\Menu;
use Igniter\Local\Facades\Location;
use Igniter\Local\Models\Location as LocationModel;
use Igniter\Orange\Livewire\CartItemModal;
use Livewire\Livewire;

beforeEach(function() {
    $location = LocationModel::factory()->create();
    $orderTypeMock = $this->mock(AbstractOrderType::class);
    $orderTypeMock->shouldReceive('getCode')->andReturn(LocationModel::DELIVERY);
    $orderTypeMock->shouldReceive('isDisabled')->andReturnFalse();
    Location::shouldReceive('getId')->andReturn($location->getKey());
    Location::shouldReceive('current')->andReturn($location);
    Location::shouldReceive('getOrderType')->andReturn($orderTypeMock);
    Location::shouldReceive('orderTypeIsDelivery')->andReturnFalse();
    Location::shouldReceive('checkNoOrderTypeAvailable')->andReturnFalse();
    Location::shouldReceive('checkOrderTime')->andReturnTrue();
    Location::shouldReceive('orderDateTime')->andReturnTrue();
});

it('can mount and prepare props', function() {
    $menu = Menu::factory()->create();

    Livewire::test(CartItemModal::class, ['menuId' => $menu->getKey()])
        ->assertSet('menuId', $menu->getKey())
        ->assertSet('rowId', null)
        ->assertSet('quantity', $menu->minimum_qty)
        ->assertSet('comment', null)
        ->assertSet('menuOptions', [])
        ->assertNotSet('price', 0)
        ->assertSet('total', 0)
        ->assertSet('minQuantity', $menu->minimum_qty);
});

it('can save cart item', function() {
    $menu = Menu::factory()->create();

    Livewire::test(CartItemModal::class, ['menuId' => $menu->getKey()])
        ->set('quantity', $menu->minimum_qty * 2)
        ->set('comment', 'No onions')
        ->set('menuOptions', ['option1', 'option2'])
        ->call('onSave')
        ->assertDispatched('hideModal');
});
