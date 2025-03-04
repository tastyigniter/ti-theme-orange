<?php

declare(strict_types=1);

namespace Igniter\Orange\Tests\View\Components;

use Igniter\Cart\Models\Order;
use Igniter\Main\Traits\ConfigurableComponent;
use Igniter\Main\Traits\UsesPage;
use Igniter\Orange\View\Components\OrderList;
use Igniter\User\Facades\Auth;
use Igniter\User\Models\Customer;

it('initializes order list component correctly', function(): void {
    $component = new OrderList(10, 'updated_at asc', 'account.orders');

    expect(class_uses_recursive($component))->toContain(ConfigurableComponent::class, UsesPage::class)
        ->and($component->itemsPerPage)->toBe(10)
        ->and($component->sortOrder)->toBe('updated_at asc')
        ->and($component->orderPage)->toBe('account.orders');
});

it('returns correct component meta', function(): void {
    $meta = OrderList::componentMeta();

    expect($meta['code'])->toBe('igniter-orange::order-list')
        ->and($meta['name'])->toBe('igniter.orange::default.component_order_list_title')
        ->and($meta['description'])->toBe('igniter.orange::default.component_order_list_desc');
});

it('defines properties correctly', function(): void {
    $component = new OrderList;
    $properties = $component->defineProperties();

    expect($properties['itemsPerPage']['label'])->toBe('Number of orders to display per page')
        ->and($properties['itemsPerPage']['type'])->toBe('number')
        ->and($properties['sortOrder']['label'])->toBe('Default sort order of orders.')
        ->and($properties['sortOrder']['type'])->toBe('select')
        ->and($properties['orderPage']['label'])->toBe('Page to redirect to when an order is clicked.')
        ->and($properties['orderPage']['type'])->toBe('select');
});

it('returns correct sort order options', function(): void {
    $options = OrderList::getSortOrderOptions();

    expect($options)->toBe([
        'order_id asc' => 'order_id asc',
        'order_id desc' => 'order_id desc',
        'created_at asc' => 'created_at asc',
        'created_at desc' => 'created_at desc',
        'total asc' => 'total asc',
        'total desc' => 'total desc',
        'order_date asc' => 'order_date asc',
        'order_date desc' => 'order_date desc',
        'order_time asc' => 'order_time asc',
        'order_time desc' => 'order_time desc',
        'order_type asc' => 'order_type asc',
        'order_type desc' => 'order_type desc',
    ]);
});

it('renders view with orders', function(): void {
    $customer = Customer::factory()->create();
    $customer->orders()->save($order = Order::factory()->create(['processed' => 1]));
    Auth::shouldReceive('customer')->andReturn($customer);

    $component = new OrderList;
    $view = $component->render();

    expect($view->getData()['orders']->pluck('order_id'))->toContain($order->order_id);
});

it('renders view with empty orders when no authenticated customer', function(): void {
    Auth::shouldReceive('customer')->andReturn(null);

    $component = new OrderList;
    $view = $component->render();

    expect($view->getData()['orders'])->toBeEmpty();
});
