<?php

declare(strict_types=1);

namespace Igniter\Orange\Tests\Livewire;

use Igniter\Main\Traits\ConfigurableComponent;
use Igniter\Main\Traits\UsesPage;
use Igniter\Orange\Livewire\ResetPassword;
use Igniter\System\Mail\AnonymousTemplateMailable;
use Igniter\User\Models\Customer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;

it('initialize component correctly', function(): void {
    $component = new ResetPassword;

    expect(class_uses_recursive($component))
        ->toContain(ConfigurableComponent::class, UsesPage::class)
        ->and($component->resetPage)->toBe('account.reset')
        ->and($component->loginPage)->toBe('account.login')
        ->and($component->email)->toBeNull()
        ->and($component->resetCode)->toBeNull()
        ->and($component->password)->toBeNull()
        ->and($component->password_confirmation)->toBeNull()
        ->and($component->message)->toBeNull();
});

it('returns correct component meta', function(): void {
    $meta = ResetPassword::componentMeta();

    expect($meta['code'])->toBe('igniter-orange::reset-password')
        ->and($meta['name'])->toBe('igniter.orange::default.component_reset_password_title')
        ->and($meta['description'])->toBe('igniter.orange::default.component_reset_password_desc');
});

it('defines properties correctly', function(): void {
    $component = new ResetPassword;
    $properties = $component->defineProperties();

    expect(array_keys($properties))->toContain(
        'resetPage',
        'loginPage',
    );
});

it('mounts and prepares props', function(): void {
    Livewire::test(ResetPassword::class)
        ->assertSet('resetPage', 'account.reset')
        ->assertSet('loginPage', 'account.login')
        ->assertSet('email', null)
        ->assertSet('resetCode', null)
        ->assertSet('password', null)
        ->assertSet('password_confirmation', null)
        ->assertSet('message', null);
});

it('handles forgot password', function(): void {
    Mail::fake();

    $customer = Customer::factory()->create([
        'email' => 'test@example.com',
    ]);

    Livewire::test(ResetPassword::class)
        ->set('email', $customer->email)
        ->call('onForgotPassword');

    expect($customer->fresh()->reset_code)->not->toBeNull();

    Mail::assertQueued(AnonymousTemplateMailable::class, fn($mailable): bool => $mailable->getTemplateCode() === 'igniter.user::mail.password_reset_request');
});

it('handles reset password', function(): void {
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

    Mail::assertQueued(AnonymousTemplateMailable::class, fn($mailable): bool => $mailable->getTemplateCode() === 'igniter.user::mail.password_reset');
});

it('throws exception when handles reset password fails', function(): void {
    Mail::fake();

    $customer = Customer::factory()->create([
        'email' => 'test@example.com',
    ]);

    Livewire::test(ResetPassword::class)
        ->set('resetCode', str_random())
        ->set('password', 'new-password')
        ->set('password_confirmation', 'new-password')
        ->call('onResetPassword')
        ->assertHasErrors(['password']);
});
