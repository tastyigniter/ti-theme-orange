<?php

namespace Igniter\Orange\Tests\Livewire;

use Igniter\Orange\Livewire\Register;
use Igniter\System\Mail\AnonymousTemplateMailable;
use Igniter\User\Models\Customer;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;

it('mounts and prepare props', function() {
    Livewire::test(Register::class)
        ->assertSet('activationCode', '')
        ->assertSet('activationPage', 'account.register')
        ->assertSet('agreeTermsSlug', null)
        ->assertSet('requireRegistrationTerms', false)
        ->assertSet('registrationAllowed', true)
        ->assertSet('redirectPage', 'account.account')
        ->assertSet('loginPage', 'account.login');
});

it('registers customer', function() {
    Mail::fake();

    Livewire::test(Register::class)
        ->set('form.first_name', 'John')
        ->set('form.last_name', 'Doe')
        ->set('form.email', 'test@example.com')
        ->set('form.password', 'password')
        ->set('form.password_confirmation', 'password')
        ->set('form.telephone', '123456789')
        ->set('form.terms', true)
        ->call('onRegister')
        ->assertRedirect();

    Mail::assertQueued(AnonymousTemplateMailable::class, function($mail) {
        return $mail->getTemplateCode() === 'igniter.user::mail.registration';
    });
});

it('activates customer', function() {
    Mail::fake();

    $customer = Customer::factory()->create([
        'is_activated' => 0,
        'activated_at' => null,
        'status' => false,
    ]);

    Livewire::test(Register::class)
        ->set('activationCode', $customer->getActivationCode())
        ->call('onActivate')
        ->assertRedirect();

    Mail::assertQueued(AnonymousTemplateMailable::class, function($mail) {
        return $mail->getTemplateCode() === 'igniter.user::mail.registration';
    });
});
