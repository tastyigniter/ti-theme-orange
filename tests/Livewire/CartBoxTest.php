<?php

declare(strict_types=1);

namespace Igniter\Orange\Tests\Livewire;

use Igniter\Cart\Classes\AbstractOrderType;
use Igniter\Cart\Facades\Cart;
use Igniter\Cart\Models\Menu;
use Igniter\Coupons\Models\Coupon;
use Igniter\Flame\Exception\ApplicationException;
use Igniter\Local\Facades\Location;
use Igniter\Local\Models\Location as LocationModel;
use Igniter\Main\Traits\ConfigurableComponent;
use Igniter\Main\Traits\UsesPage;
use Igniter\Orange\Livewire\CartBox;
use Illuminate\Support\Facades\Event;
use Livewire\Livewire;

beforeEach(function(): void {
    $this->location = LocationModel::factory()->create();
    $this->orderTypeMock = $this->mock(AbstractOrderType::class);
    $this->orderTypeMock->shouldReceive('getSchedule')->andReturn($this->location->newWorkingSchedule(LocationModel::COLLECTION, 5));
    $this->orderTypeMock->shouldReceive('getCode')->andReturn(LocationModel::COLLECTION);
    Location::shouldReceive('getId')->andReturn($this->location->getKey());
    Location::shouldReceive('current')->andReturn($this->location);
    Location::shouldReceive('orderType')->byDefault()->andReturn(LocationModel::COLLECTION);
    Location::shouldReceive('getOrderType')->andReturn($this->orderTypeMock);
    Location::shouldReceive('checkOrderTime')->byDefault()->andReturnTrue();
    Location::shouldReceive('orderDateTime')->byDefault()->andReturn(now());
    Location::shouldReceive('checkNoOrderTypeAvailable')->andReturnFalse();
    Location::shouldReceive('minimumOrderTotal')->andReturn(0);
});

it('initialize component correctly', function(): void {
    $component = new CartBox;

    expect(class_uses_recursive($component))
        ->toContain(ConfigurableComponent::class, UsesPage::class)
        ->and($component->checkoutPage)->toBe('checkout.checkout')
        ->and($component->tipAmount)->toBe(0)
        ->and($component->isCustomTip)->toBeFalse()
        ->and($component->couponCode)->toBeNull();
});

it('returns correct component meta', function(): void {
    $meta = CartBox::componentMeta();

    expect($meta['code'])->toBe('igniter-orange::cart-box')
        ->and($meta['name'])->toBe('igniter.orange::default.component_cartbox_title')
        ->and($meta['description'])->toBe('igniter.orange::default.component_cartbox_desc');
});

it('defines properties correctly', function(): void {
    $component = new CartBox;
    $properties = $component->defineProperties();

    expect(array_keys($properties))->toContain('checkoutPage');
});

it('mounts and prepare props', function(): void {
    Livewire::test(CartBox::class)
        ->assertSet('checkoutPage', 'checkout.checkout')
        ->assertSet('tipAmount', 0)
        ->assertSet('isCustomTip', false)
        ->assertSet('couponCode', null);
});

it('updates tip amount', function(): void {
    Livewire::test(CartBox::class)
        ->set('tipAmount', 10)
        ->assertSet('tipAmount', 10);
});

it('opens cart item modal', function(): void {
    Livewire::test(CartBox::class)
        ->call('onOpenItemModal', rowId: 1, menuId: 2)
        ->assertDispatched('showModal');
});

it('adds item', function(): void {
    $menuItem = Menu::factory()->create();
    Location::shouldReceive('orderTypeIsDelivery')->andReturnFalse();
    Location::shouldReceive('orderDateTime')->andReturn(now());
    Location::shouldReceive('orderType')->andReturn(LocationModel::COLLECTION);
    Location::shouldReceive('checkMinimumOrderTotal')->andReturnTrue();
    $this->orderTypeMock->shouldReceive('isDisabled')->andReturnFalse();

    Livewire::test(CartBox::class)
        ->dispatch('cart-box:add-item', menuId: $menuItem->getKey(), quantity: 1);

    expect(Cart::content())->toHaveCount(1);
});

it('updates cart item quantity', function(): void {
    $menuItem = Menu::factory()->create();
    $cartItem = Cart::add([
        'id' => $menuItem->getKey(),
        'name' => 'Test Item',
        'price' => 10,
    ], 1);
    Location::shouldReceive('orderType')->andReturn(LocationModel::COLLECTION);
    Location::shouldReceive('checkMinimumOrderTotal')->andReturnTrue();
    Location::shouldReceive('orderTypeIsDelivery')->andReturnFalse();

    Livewire::test(CartBox::class)
        ->call('onUpdateItemQuantity', rowId: $cartItem->rowId, action: 'plus');

    expect(Cart::content()->first()->qty)->toBe(2);
});

it('applies coupon', function(): void {
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

it('applies tip', function(): void {
    Livewire::test(CartBox::class)
        ->call('onApplyTip', 10, true)
        ->assertSet('tipAmount', 10)
        ->assertSet('isCustomTip', true);
});

it('removes condition', function(): void {
    Livewire::test(CartBox::class)
        ->call('onRemoveCondition', 'tip')
        ->assertSet('tipAmount', 0)
        ->assertSet('isCustomTip', false);
});

it('proceeds to checkout fails when location is not found', function(): void {
    Location::shouldReceive('getById')->andReturnNull();

    $this->expectException(ApplicationException::class);
    $this->expectExceptionMessage(lang('igniter.local::default.alert_location_required'));

    Livewire::test(CartBox::class)
        ->call('onProceedToCheckout', $this->location->getKey())
        ->assertRedirect(route('checkout.checkout'));
});

it('proceeds to checkout', function(): void {
    Location::shouldReceive('getById')->andReturn($this->location);
    Location::shouldReceive('setCurrent')->with($this->location)->once();
    Location::shouldReceive('checkMinimumOrderTotal')->andReturnTrue();
    Location::shouldReceive('orderTypeIsDelivery')->andReturnFalse();
    Location::shouldReceive('orderType')->andReturn(LocationModel::COLLECTION);

    Livewire::test(CartBox::class)
        ->call('onProceedToCheckout', $this->location->getKey())
        ->assertRedirect(page_url('checkout.checkout'));
});

it('has minimum order', function(): void {
    Location::shouldReceive('checkMinimumOrderTotal')->andReturnFalse();

    Livewire::test(CartBox::class)
        ->call('hasMinimumOrder')
        ->assertReturned(true);
});

it('button label returns location closed', function(): void {
    Location::shouldReceive('checkOrderTime')->andReturnFalse();

    Livewire::test(CartBox::class)
        ->call('buttonLabel')
        ->assertReturned(lang('igniter.cart::default.text_is_closed'));
});

it('button label returns cart is empty', function(): void {
    $menuItem = Menu::factory()->create();
    Cart::add([
        'id' => $menuItem->getKey(),
        'name' => 'Test Item',
        'price' => 10,
    ], 1);
    Location::shouldReceive('orderType')->andReturn(LocationModel::COLLECTION);
    Location::shouldReceive('checkMinimumOrderTotal')->andReturnTrue();
    Location::shouldReceive('orderTypeIsDelivery')->andReturnFalse();

    Livewire::test(CartBox::class)
        ->call('buttonLabel')
        ->assertReturned(lang('igniter.cart::default.button_order').' · '.currency_format(10));
});

it('returns true when tipping is enabled', function(): void {
    Livewire::test(CartBox::class)
        ->call('tippingEnabled')
        ->assertReturned(false);
});

it('returns configured tipping amounts', function(): void {
    Livewire::test(CartBox::class)
        ->call('tippingAmounts')
        ->assertReturned([]);
});
