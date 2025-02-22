<?php

namespace Igniter\Orange\Tests\Livewire;

use Igniter\Main\Traits\ConfigurableComponent;
use Igniter\Main\Traits\UsesPage;
use Igniter\Orange\Livewire\Login;
use Igniter\User\Models\Customer;
use Livewire\Livewire;

it('initialize component correctly', function() {
    $component = new Login;

    expect(class_uses_recursive($component))
        ->toContain(ConfigurableComponent::class, UsesPage::class)
        ->and($component->registrationAllowed)->toBeTrue()
        ->and($component->redirectPage)->toBe('account.account');
});

it('returns correct component meta', function() {
    $meta = Login::componentMeta();

    expect($meta['code'])->toBe('igniter-orange::login')
        ->and($meta['name'])->toBe('igniter.orange::default.component_login_title')
        ->and($meta['description'])->toBe('igniter.orange::default.component_login_desc');
});

it('defines properties correctly', function() {
    $component = new Login;
    $properties = $component->defineProperties();

    expect(array_keys($properties))->toContain('redirectPage');
});

it('mounts and prepare props', function() {
    Livewire::test(Login::class)
        ->assertSet('registrationAllowed', true)
        ->assertSet('redirectPage', 'account.account');
});

it('does not set an intended redirect url when one is already set', function() {
    redirect()->setIntendedUrl(page_url('account/orders'));

    Livewire::test(Login::class);

    expect(redirect()->getIntendedUrl())->toBe(page_url('account/orders'));
});

it('does not set an intended redirect url when previous url is external', function() {
    Livewire::withHeaders(['referer' => 'https://google.com'])
        ->test(Login::class);

    expect(redirect()->getIntendedUrl())->toBeNull();
});

it('returns current authenticated customer', function() {
    $customer = Customer::factory()->create();

    Livewire::test(Login::class)
        ->call('customer')
        ->assertReturned(null);

    Livewire::actingAs($customer, 'igniter-customer')
        ->test(Login::class)
        ->call('customer')
        ->assertReturned(function($value) use ($customer) {
            return $value['customer_id'] === $customer->getKey();
        });
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

it('logs in user and redirects to custom url', function() {
    $customer = Customer::factory()->create();

    Livewire::withQueryParams(['redirect' => 'account/orders'])
        ->test(Login::class)
        ->set('form.email', $customer->email)
        ->set('form.password', 'password')
        ->set('form.remember', true)
        ->call('onLogin')
        ->assertRedirect(page_url('account/orders'));
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
