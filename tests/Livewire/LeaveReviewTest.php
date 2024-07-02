<?php

namespace Igniter\Orange\Tests\Livewire;

use Igniter\Cart\Models\Order;
use Igniter\Local\Models\Review;
use Igniter\Orange\Livewire\LeaveReview;
use Igniter\User\Models\Customer;
use Livewire\Livewire;

it('mounts and prepare props', function() {
    Livewire::test(LeaveReview::class)
        ->assertSet('type', 'order')
        ->assertSet('hashParamName', 'hash')
        ->assertSet('reviewableHash', null)
        ->assertSet('comment', null)
        ->assertSet('delivery', 0)
        ->assertSet('quality', 0)
        ->assertSet('service', 0);
});

it('leaves review', function() {
    $customer = Customer::factory()->create();
    $order = Order::factory()->create([
        'customer_id' => $customer->getKey(),
        'processed' => '1',
    ]);

    $order->status_history()->create([
        'status_id' => setting('completed_order_status')[0],
        'comment' => 'Order completed',
    ]);

    Livewire::actingAs($customer, 'igniter-customer')
        ->test(LeaveReview::class)
        ->set('reviewableHash', $order->hash)
        ->set('delivery', 5)
        ->set('quality', 5)
        ->set('service', 5)
        ->set('comment', 'Great service!')
        ->call('onLeaveReview');

    expect(Review::firstWhere([
        'review_text' => 'Great service!',
        'delivery' => 5,
        'quality' => 5,
        'service' => 5,
    ]))->not->toBeNull();
});
