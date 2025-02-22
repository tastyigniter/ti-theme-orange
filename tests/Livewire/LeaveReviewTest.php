<?php

namespace Igniter\Orange\Tests\Livewire;

use Igniter\Cart\Models\Order;
use Igniter\Local\Models\Review;
use Igniter\Orange\Livewire\LeaveReview;
use Igniter\Reservation\Models\Reservation;
use Igniter\User\Models\Customer;
use Livewire\Livewire;

it('returns correct component meta', function() {
    $meta = LeaveReview::componentMeta();

    expect($meta['code'])->toBe('igniter-orange::leave-review')
        ->and($meta['name'])->toBe('igniter.orange::default.component_leave_review_title')
        ->and($meta['description'])->toBe('igniter.orange::default.component_leave_review_desc');
});

it('defines properties correctly', function() {
    $component = new LeaveReview;
    $properties = $component->defineProperties();

    expect(array_keys($properties))->toContain('type');
});

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

it('errors when leaving a review for an incomplete order', function() {
    $customer = Customer::factory()->create();
    $order = Order::factory()->create([
        'customer_id' => $customer->getKey(),
        'processed' => '1',
    ]);
    Livewire::actingAs($customer, 'igniter-customer')
        ->test(LeaveReview::class)
        ->set('reviewableHash', $order->hash)
        ->set('delivery', 5)
        ->set('quality', 5)
        ->set('service', 5)
        ->set('comment', 'Great service!')
        ->call('onLeaveReview')
        ->assertHasErrors(['comment']);
});

it('leaves review for order', function() {
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
        'reviewable_type' => 'orders',
        'review_text' => 'Great service!',
        'delivery' => 5,
        'quality' => 5,
        'service' => 5,
    ]))->not->toBeNull();
});

it('leaves review for reservation', function() {
    $customer = Customer::factory()->create();
    $reservation = Reservation::factory()->create([
        'customer_id' => $customer->getKey(),
    ]);
    $reservation->status_history()->create([
        'status_id' => setting('confirmed_reservation_status'),
        'comment' => 'Reservation completed',
    ]);

    Livewire::actingAs($customer, 'igniter-customer')
        ->test(LeaveReview::class, ['type' => 'reservation'])
        ->set('reviewableHash', $reservation->hash)
        ->set('delivery', 5)
        ->set('quality', 5)
        ->set('service', 5)
        ->set('comment', 'Great service!')
        ->call('onLeaveReview');

    expect(Review::firstWhere([
        'reviewable_type' => 'reservations',
        'review_text' => 'Great service!',
        'delivery' => 5,
        'quality' => 5,
        'service' => 5,
    ]))->not->toBeNull();
});

