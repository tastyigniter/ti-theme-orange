<?php

declare(strict_types=1);

namespace Igniter\Orange\Tests;

use Igniter\User\Models\Customer;

it('renders components on homepage', function(): void {
    $this->get(route('igniter.theme.home'))
        ->assertSeeLivewire('igniter-orange::slider')
        ->assertSeeLivewire('igniter-orange::local-search')
        ->assertSeeLivewire('igniter-orange::featured-items');
})->skip();

it('renders components on contact page', function(): void {})->skip();

it('renders components on cart page', function(): void {})->skip();

it('renders components on locations page', function(): void {})->skip();

it('renders components on account dashboard page', function(): void {
    $customer = Customer::factory()->create();

    $this
        ->actingAs($customer, 'igniter-customer')
        ->get(route('igniter.theme.account.account'))
        ->assertSee(sprintf(lang('igniter.user::default.text_welcome'), $customer->full_name))
        ->assertSeeLivewire('igniter-orange::account-settings');

})->skip();

it('renders components on account address book page', function(): void {})->skip();

it('renders components on account login page', function(): void {})->skip();

it('renders components on account order page', function(): void {})->skip();

it('renders components on account orders page', function(): void {})->skip();

it('renders components on account register page', function(): void {})->skip();

it('renders components on account reservation page', function(): void {})->skip();

it('renders components on account reservations page', function(): void {})->skip();

it('renders components on account password reset page', function(): void {})->skip();

it('renders components on confirm social login email page', function(): void {})->skip();

it('renders components on menu page', function(): void {
    $this->get(route('igniter.theme.local.menus'))
        ->assertSeeLivewire('igniter-orange::local-header')
        ->assertSeeLivewire('igniter-orange::fulfillment')
        ->assertSeeLivewire('igniter-orange::category-list')
        ->assertSeeLivewire('igniter-orange::menu-item-list')
        ->assertSeeLivewire('igniter-orange::cart-box')
        ->assertSeeLivewire('igniter-orange::fulfillment-modal');
})->skip();
