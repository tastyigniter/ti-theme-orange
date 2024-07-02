<?php

namespace Igniter\Orange\Tests\Livewire;

use Igniter\Orange\Livewire\Login;
use Igniter\User\Models\Customer;
use Livewire\Livewire;

it('mounts and prepare props', function() {
    Livewire::test(Login::class)
        ->assertSet('registrationAllowed', true)
        ->assertSet('redirectPage', 'account.account');
});

it('logs in user', function() {
    $customer = Customer::factory()->create();

    Livewire::test(Login::class)
        ->set('form.email', $customer->email)
        ->set('form.password', 'password')
        ->set('form.remember', true)
        ->call('onLogin')
        ->assertRedirect();
});

it('fails to log in user with invalid credentials', function() {
    Livewire::test(Login::class)
        ->set('form.email', 'test@email.com')
        ->set('form.password', 'password')
        ->call('onLogin')
        ->assertHasErrors(['form.email']);
});

it('fails to log in user with invalid email', function() {
    Livewire::test(Login::class)
        ->set('form.email', 'testemail.com')
        ->set('form.password', 'password')
        ->call('onLogin')
        ->assertHasErrors(['form.email']);
});

it('fails to log in user with invalid password', function() {
    $customer = Customer::factory()->create();

    Livewire::test(Login::class)
        ->set('form.email', $customer->email)
        ->set('form.password', 'pass')
        ->call('onLogin')
        ->assertHasErrors(['form.password']);
});

it('fails to log in user with empty email', function() {
    Livewire::test(Login::class)
        ->set('form.email', '')
        ->set('form.password', 'password')
        ->call('onLogin')
        ->assertHasErrors(['form.email']);
});
