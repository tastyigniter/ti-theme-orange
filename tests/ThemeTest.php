<?php

namespace Igniter\Orange\Tests;

use Igniter\User\Models\Customer;

it('renders components on homepage', function() {
    $this->get(route('igniter.theme.home'))
        ->assertSeeLivewire('igniter-orange::slider')
        ->assertSeeLivewire('igniter-orange::local-search')
        ->assertSeeLivewire('igniter-orange::featured-items');
})->skip();

it('renders components on contact page', function() {})->skip();

it('renders components on cart page', function() {})->skip();

it('renders components on locations page', function() {})->skip();

it('renders components on account dashboard page', function() {
    $customer = Customer::factory()->create();

    $this
        ->actingAs($customer, 'igniter-customer')
        ->get(route('igniter.theme.account.account'))
        ->assertSee(sprintf(lang('igniter.user::default.text_welcome'), $customer->full_name))
        ->assertSeeLivewire('igniter-orange::account-settings');

})->skip();

it('renders components on account address book page', function() {})->skip();

it('renders components on account login page', function() {})->skip();

it('renders components on account order page', function() {})->skip();

it('renders components on account orders page', function() {})->skip();

it('renders components on account register page', function() {})->skip();

it('renders components on account reservation page', function() {})->skip();

it('renders components on account reservations page', function() {})->skip();

it('renders components on account password reset page', function() {})->skip();

it('renders components on confirm social login email page', function() {})->skip();

it('renders components on menu page', function() {
    $this->get(route('igniter.theme.local.menus'))
        ->assertSeeLivewire('igniter-orange::local-header')
        ->assertSeeLivewire('igniter-orange::fulfillment')
        ->assertSeeLivewire('igniter-orange::category-list')
        ->assertSeeLivewire('igniter-orange::menu-item-list')
        ->assertSeeLivewire('igniter-orange::cart-box')
        ->assertSeeLivewire('igniter-orange::fulfillment-modal');
})->skip();
