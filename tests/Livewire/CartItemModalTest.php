<?php

declare(strict_types=1);

namespace Igniter\Orange\Tests\Livewire;

use Igniter\Cart\Classes\AbstractOrderType;
use Igniter\Cart\Facades\Cart;
use Igniter\Cart\Models\Menu;
use Igniter\Local\Facades\Location;
use Igniter\Local\Models\Location as LocationModel;
use Igniter\Main\Traits\ConfigurableComponent;
use Igniter\Orange\Livewire\CartItemModal;
use Livewire\Livewire;

beforeEach(function(): void {
    $this->location = LocationModel::factory()->create();
    $this->orderTypeMock = $this->mock(AbstractOrderType::class);
    $this->orderTypeMock->shouldReceive('getCode')->andReturn(LocationModel::DELIVERY);
    $this->orderTypeMock->shouldReceive('isDisabled')->andReturnFalse();
    Location::shouldReceive('getId')->andReturn($this->location->getKey());
    Location::shouldReceive('current')->andReturn($this->location);
    Location::shouldReceive('orderType')->andReturn(LocationModel::DELIVERY);
    Location::shouldReceive('getOrderType')->andReturn($this->orderTypeMock);
    Location::shouldReceive('orderTypeIsDelivery')->andReturnFalse();
    Location::shouldReceive('checkNoOrderTypeAvailable')->andReturnFalse();
    Location::shouldReceive('checkOrderTime')->andReturnTrue();
    Location::shouldReceive('orderDateTime')->andReturn(now());
});

it('initialize component correctly', function(): void {
    $component = new CartItemModal;

    expect(class_uses_recursive($component))
        ->toContain(ConfigurableComponent::class)
        ->and($component->menuId)->toBeNull()
        ->and($component->rowId)->toBeNull()
        ->and($component->quantity)->toBeNull()
        ->and($component->comment)->toBeNull()
        ->and($component->menuOptions)->toBeArray()
        ->and($component->price)->toBe(0.0)
        ->and($component->total)->toBe(0.0)
        ->and($component->minQuantity)->toBeNull()
        ->and($component->showThumb)->toBeTrue()
        ->and($component->thumbWidth)->toBe(720)
        ->and($component->thumbHeight)->toBe(300)
        ->and($component->hideZeroOptionPrices)->toBeFalse()
        ->and($component->limitOptionsValues)->toBe(6);
});

it('returns correct component meta', function(): void {
    $meta = CartItemModal::componentMeta();

    expect($meta['code'])->toBe('igniter-orange::cart-item-modal')
        ->and($meta['name'])->toBe('igniter.orange::default.component_cart_item_modal_title')
        ->and($meta['description'])->toBe('igniter.orange::default.component_cart_item_modal_desc');
});

it('defines properties correctly', function(): void {
    $component = new CartItemModal;
    $properties = $component->defineProperties();

    expect(array_keys($properties))->toContain(
        'showThumb',
        'thumbWidth',
        'thumbHeight',
        'hideZeroOptionPrices',
        'limitOptionsValues',
    );
});

it('can mount and prepare props', function(): void {
    $menu = Menu::factory()->create();
    $cartItem = Cart::add([
        'id' => $menu->getKey(),
        'name' => 'Test Item',
        'price' => 10,
    ], 1);

    Livewire::test(CartItemModal::class, ['menuId' => $menu->getKey(), 'rowId' => $cartItem->rowId])
        ->assertSet('menuId', $menu->getKey())
        ->assertSet('rowId', $cartItem->rowId)
        ->assertSet('quantity', $menu->minimum_qty)
        ->assertSet('comment', null)
        ->assertSet('menuOptions', [])
        ->assertNotSet('price', 0)
        ->assertSet('total', 0)
        ->assertSet('minQuantity', $menu->minimum_qty);
});

it('can save cart item', function(): void {
    $menu = Menu::factory()->create();

    Livewire::test(CartItemModal::class, ['menuId' => $menu->getKey()])
        ->set('quantity', $menu->minimum_qty * 2)
        ->set('comment', 'No onions')
        ->set('menuOptions', ['option1', 'option2'])
        ->call('onSave')
        ->assertDispatched('hideModal');
});

it('throws exception when saving cart item fails', function(): void {
    $menu = Menu::factory()->create();

    Livewire::test(CartItemModal::class, ['menuId' => $menu->getKey()])
        ->set('quantity', 0)
        ->call('onSave')
        ->assertHasErrors(['menuOptions']);
});

it('returns current location id', function(): void {
    $menu = Menu::factory()->create();

    Livewire::test(CartItemModal::class, ['menuId' => $menu->getKey()])
        ->call('getLocationId')
        ->assertReturned($this->location->getKey());
});

it('returns cart item option quantity type value', function(): void {
    $menu = Menu::factory()->create();
    $cartItem = Cart::add([
        'id' => $menu->getKey(),
        'name' => 'Test Item',
        'price' => 10,
        'options' => [
            [
                'id' => 111,
                'name' => 'Size',
                'values' => [
                    [
                        'id' => 1113,
                        'name' => 'Large',
                        'price' => 2.00,
                    ],
                ],
            ],
        ],
    ], 1);

    Livewire::test(CartItemModal::class, ['menuId' => $menu->getKey(), 'rowId' => $cartItem->rowId])
        ->call('getOptionQuantityTypeValue', 1113)
        ->assertReturned(1);
});
