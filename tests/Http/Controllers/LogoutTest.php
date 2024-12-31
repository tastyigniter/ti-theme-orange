<?php

namespace Igniter\Orange\Tests\Http\Controllers;

use Igniter\User\Facades\Auth;
use Igniter\User\Models\Customer;

it('logs out the user', function() {
    $customer = Customer::factory()->create();

    $this->actingAs($customer)->get(route('igniter.theme.account.logout'));

    expect(Auth::check())->toBeFalse();
});
