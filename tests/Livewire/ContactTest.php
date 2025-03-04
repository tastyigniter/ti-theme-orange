<?php

declare(strict_types=1);

namespace Igniter\Orange\Tests\Livewire;

use Igniter\Main\Traits\ConfigurableComponent;
use Igniter\Orange\Livewire\Contact;
use Igniter\System\Mail\AnonymousTemplateMailable;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;

it('initialize component correctly', function(): void {
    $component = new Contact;

    expect(class_uses_recursive($component))
        ->toContain(ConfigurableComponent::class)
        ->and($component->subject)->toBeNull()
        ->and($component->email)->toBeNull()
        ->and($component->fullName)->toBeNull()
        ->and($component->telephone)->toBeNull()
        ->and($component->comment)->toBeNull()
        ->and($component->subjects)->toEqual([
            'igniter.orange::default.contact.text_general_enquiry',
            'igniter.orange::default.contact.text_comment',
            'igniter.orange::default.contact.text_technical_issues',
        ]);
});

it('returns correct component meta', function(): void {
    $meta = Contact::componentMeta();

    expect($meta['code'])->toBe('igniter-orange::contact')
        ->and($meta['name'])->toBe('igniter.orange::default.component_contact_title')
        ->and($meta['description'])->toBe('igniter.orange::default.component_contact_desc');
});

it('mounts and prepare props', function(): void {
    Livewire::test(Contact::class)
        ->assertSet('subject', null)
        ->assertSet('email', null)
        ->assertSet('fullName', null)
        ->assertSet('telephone', null)
        ->assertSet('comment', null)
        ->assertSet('message', null);
});

it('submits contact form', function(): void {
    Mail::fake();

    Livewire::test(Contact::class)
        ->set('subject', 'General Enquiry')
        ->set('email', 'test@example.com')
        ->set('fullName', 'John Doe')
        ->set('telephone', '1234567890')
        ->set('comment', 'This is a test comment.')
        ->call('onSubmit')
        ->assertSet('message', lang('igniter.orange::default.contact.alert_contact_sent'));

    Mail::assertQueued(AnonymousTemplateMailable::class, fn($mail): bool => $mail->getTemplateCode() === 'igniter.frontend::mail.contact');
});

it('fails to submit contact form with invalid fields', function(): void {
    Livewire::test(Contact::class)
        ->set('subject', 'General Enquiry')
        ->set('email', '')
        ->set('fullName', '')
        ->set('telephone', '1234567890')
        ->set('comment', 'This is a test comment.')
        ->call('onSubmit')
        ->assertHasErrors(['email', 'fullName']);
});
