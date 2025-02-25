<?php

declare(strict_types=1);

namespace Igniter\Orange\Tests\Livewire;

use Igniter\Admin\Models\Status;
use Igniter\Cart\Classes\OrderManager;
use Igniter\Cart\Models\Order;
use Igniter\Main\Traits\ConfigurableComponent;
use Igniter\Main\Traits\UsesPage;
use Igniter\Orange\Livewire\OrderPreview;
use Livewire\Livewire;

beforeEach(function(): void {
    $status = Status::factory()->create();
    $this->order = Order::factory()->create(['processed' => 1]);
    $this->order->updateOrderStatus($status->getKey());
});

it('initialize component correctly', function(): void {
    $component = new OrderPreview;

    expect(class_uses_recursive($component))
        ->toContain(ConfigurableComponent::class, UsesPage::class)
        ->and($component->hashParamName)->toBe('hash')
        ->and($component->hash)->toBeNull()
        ->and($component->loginPage)->toBe('account.login')
        ->and($component->ordersPage)->toBe('account.orders')
        ->and($component->checkoutPage)->toBe('checkout.checkout')
        ->and($component->menusPage)->toBe('local.menus')
        ->and($component->loginUrl)->toBe('')
        ->and($component->hideReorderBtn)->toBeTrue()
        ->and($component->showCancelButton)->toBeFalse();
});

it('returns correct component meta', function(): void {
    $meta = OrderPreview::componentMeta();

    expect($meta['code'])->toBe('igniter-orange::order-preview')
        ->and($meta['name'])->toBe('igniter.orange::default.component_order_preview_title')
        ->and($meta['description'])->toBe('igniter.orange::default.component_order_preview_desc');
});

it('defines properties correctly', function(): void {
    $component = new OrderPreview;
    $properties = $component->defineProperties();

    expect(array_keys($properties))->toContain(
        'hashParamName',
        'loginPage',
        'ordersPage',
        'checkoutPage',
        'menusPage',
        'hideReorderBtn',
    );
});

it('mounts and prepare props', function(): void {
    Livewire::test(OrderPreview::class, ['hash' => $this->order->hash])
        ->assertSet('hashParamName', 'hash')
        ->assertSet('loginPage', 'account.login')
        ->assertSet('ordersPage', 'account.orders')
        ->assertSet('checkoutPage', 'checkout.checkout')
        ->assertSet('menusPage', 'local.menus')
        ->assertSet('hideReorderBtn', true)
        ->assertSet('showCancelButton', false);
});

it('redirects when mounting with unprocessed order', function(): void {
    $order = Order::factory()->create();

    Livewire::test(OrderPreview::class, ['hash' => $order->hash])
        ->assertSet('order', null);
});

it('clears completed order from session', function(): void {
    resolve(OrderManager::class)->setCurrentOrderId($this->order->order_id);

    Livewire::test(OrderPreview::class, ['hash' => $this->order->hash]);

    expect(resolve(OrderManager::class)->getCurrentOrderId())->toBeNull();
});

it('gets status width for progress bars for no matching status', function(): void {
    Livewire::test(OrderPreview::class, ['hash' => $this->order->hash])
        ->call('getStatusWidthForProgressBars')
        ->assertReturned([
            'default' => '0',
            'processing' => '0',
            'completed' => '0',
        ]);
});

it('gets status width for progress bars for default status', function(): void {
    $status = Status::factory()->create();
    $order = Order::factory()->create(['processed' => 1]);
    $order->updateOrderStatus($status->getKey());

    setting()->set('default_order_status', $status->getKey());

    Livewire::test(OrderPreview::class, ['hash' => $order->hash])
        ->call('getStatusWidthForProgressBars')
        ->assertReturned([
            'default' => 50,
            'processing' => '0',
            'completed' => '0',
        ]);
});

it('gets status width for progress bars for processing status', function(): void {
    $status = Status::factory()->create();
    $order = Order::factory()->create(['processed' => 1]);
    $order->updateOrderStatus($status->getKey());

    setting()->set('processing_order_status', [$status->getKey()]);

    Livewire::test(OrderPreview::class, ['hash' => $order->hash])
        ->call('getStatusWidthForProgressBars')
        ->assertReturned([
            'default' => 100,
            'processing' => 50,
            'completed' => '0',
        ]);
});

it('gets status width for progress bars for completed status', function(): void {
    $status = Status::factory()->create();
    $order = Order::factory()->create(['processed' => 1]);
    $order->updateOrderStatus($status->getKey());

    setting()->set('completed_order_status', [$status->getKey()]);

    Livewire::test(OrderPreview::class, ['hash' => $order->hash])
        ->call('getStatusWidthForProgressBars')
        ->assertReturned([
            'default' => 100,
            'processing' => 100,
            'completed' => 100,
        ]);
});

it('shows cancel button', function(): void {
    $status = Status::factory()->create();
    $order = Order::factory()->create([
        'order_date' => now()->toDateString(),
        'order_time' => now()->addHour()->toTimeString(),
        'processed' => 1,
    ]);
    $order->updateOrderStatus($status->getKey());

    $order->location->settings()->create([
        'item' => $order->order_type,
        'data' => ['cancellation_timeout' => 15],
    ]);

    Livewire::test(OrderPreview::class, ['hash' => $order->hash])
        ->call('showCancelButton')
        ->assertReturned(true);
});

it('errors when reordering with an invalid menu item', function(): void {
    $this->order->menus()->create([
        'menu_id' => 123,
        'name' => 'Menu Name',
        'quantity' => 5,
        'price' => 20,
        'subtotal' => 100,
    ]);

    Livewire::test(OrderPreview::class, ['hash' => $this->order->hash])
        ->call('onReOrder')
        ->assertHasErrors(['onReOrder']);
});

it('handles reorder', function(): void {
    Livewire::test(OrderPreview::class, ['hash' => $this->order->hash])
        ->call('onReOrder')
        ->assertRedirect();
});

it('handles cancel order', function(): void {
    $status = Status::factory()->create();
    $order = Order::factory()->create([
        'order_date' => now()->toDateString(),
        'order_time' => now()->addHour()->toTimeString(),
        'processed' => 1,
    ]);
    $order->updateOrderStatus($status->getKey());

    $order->location->settings()->create([
        'item' => $order->order_type,
        'data' => ['cancellation_timeout' => 15],
    ]);

    Livewire::test(OrderPreview::class, ['hash' => $order->hash])
        ->call('onCancel')
        ->assertHasNoErrors();
});
