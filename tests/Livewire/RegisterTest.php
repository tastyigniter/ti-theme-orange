<?php

namespace Igniter\Orange\Tests\Livewire;

use Igniter\Main\Traits\ConfigurableComponent;
use Igniter\Main\Traits\UsesPage;
use Igniter\Orange\Livewire\Register;
use Igniter\System\Mail\AnonymousTemplateMailable;
use Igniter\User\Models\Customer;
use Igniter\User\Models\CustomerGroup;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;

it('initialize component correctly', function() {
    $component = new Register();

    expect(class_uses_recursive($component))
        ->toContain(ConfigurableComponent::class, UsesPage::class)
        ->and($component->activationCode)->toBe('')
        ->and($component->activationPage)->toBe('account.register')
        ->and($component->agreeTermsSlug)->toBeNull()
        ->and($component->requireRegistrationTerms)->toBeFalse()
        ->and($component->registrationAllowed)->toBeTrue()
        ->and($component->redirectPage)->toBe('account.account')
        ->and($component->loginPage)->toBe('account.login');
});

it('returns correct component meta', function() {
    $meta = Register::componentMeta();

    expect($meta['code'])->toBe('igniter-orange::register')
        ->and($meta['name'])->toBe('igniter.orange::default.component_register_title')
        ->and($meta['description'])->toBe('igniter.orange::default.component_register_desc');
});

it('defines properties correctly', function() {
    $component = new Register();
    $properties = $component->defineProperties();

    expect(array_keys($properties))->toContain(
        'agreeTermsSlug',
        'redirectPage',
        'activationPage',
        'loginPage',
    );
});

it('mounts and prepare props', function() {
    setting()->set('allow_registration', false);

    Livewire::test(Register::class)
        ->assertSet('requireRegistrationTerms', false)
        ->assertSet('registrationAllowed', false);
});

it('activates previously registered account on mount', function() {
    Mail::fake();

    $customer = Customer::factory()->create([
        'is_activated' => 0,
        'activated_at' => null,
        'status' => false,
    ]);

    Livewire::test(Register::class, ['activationCode' => $customer->getActivationCode()]);

    Mail::assertQueued(AnonymousTemplateMailable::class, function($mail) {
        return in_array($mail->getTemplateCode(), [
            'igniter.user::mail.registration',
            'igniter.user::mail.registration_alert',
        ]);
    });
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

it('registers customer and sends email verification', function() {
    Mail::fake();

    $customerGroup = CustomerGroup::factory()->create(['approval' => 1]);
    $customerGroup->makeDefault();
    CustomerGroup::clearDefaultModel();

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
        return $mail->getTemplateCode() === 'igniter.user::mail.activation';
    });
});
