<?php

namespace Igniter\Orange\Tests\Livewire;

use Igniter\Orange\Livewire\ResetPassword;
use Igniter\System\Mail\AnonymousTemplateMailable;
use Igniter\User\Models\Customer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;

it('mounts and prepares props', function() {
    Livewire::test(ResetPassword::class)
        ->assertSet('resetPage', 'account.reset')
        ->assertSet('loginPage', 'account.login')
        ->assertSet('email', null)
        ->assertSet('resetCode', null)
        ->assertSet('password', null)
        ->assertSet('password_confirmation', null)
        ->assertSet('message', null);
});

it('handles forgot password', function() {
    Mail::fake();

    $customer = Customer::factory()->create([
        'email' => 'test@example.com',
    ]);

    Livewire::test(ResetPassword::class)
        ->set('email', $customer->email)
        ->call('onForgotPassword');

    expect($customer->fresh()->reset_code)->not->toBeNull();

    Mail::assertQueued(AnonymousTemplateMailable::class, function($mailable) {
        return $mailable->getTemplateCode() === 'igniter.user::mail.password_reset_request';
    });
});

it('handles reset password', function() {
    Mail::fake();

    $customer = Customer::factory()->create([
        'email' => 'test@example.com',
    ]);

    $customer->resetPassword();

    Livewire::test(ResetPassword::class)
        ->set('resetCode', $customer->reset_code)
        ->set('password', 'new-password')
        ->set('password_confirmation', 'new-password')
        ->call('onResetPassword');

    expect(Hash::check('new-password', $customer->fresh()->password))->toBeTrue();

    Mail::assertQueued(AnonymousTemplateMailable::class, function($mailable) {
        return $mailable->getTemplateCode() === 'igniter.user::mail.password_reset';
    });
});
