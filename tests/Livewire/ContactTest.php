<?php

namespace Igniter\Orange\Tests\Livewire;

use Igniter\Orange\Livewire\Contact;
use Igniter\System\Mail\AnonymousTemplateMailable;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;

it('mounts and prepare props', function() {
    Livewire::test(Contact::class)
        ->assertSet('subject', null)
        ->assertSet('email', null)
        ->assertSet('fullName', null)
        ->assertSet('telephone', null)
        ->assertSet('comment', null)
        ->assertSet('message', null);
});

it('submits contact form', function() {
    Mail::fake();

    Livewire::test(Contact::class)
        ->set('subject', 'General Enquiry')
        ->set('email', 'test@example.com')
        ->set('fullName', 'John Doe')
        ->set('telephone', '1234567890')
        ->set('comment', 'This is a test comment.')
        ->call('onSubmit')
        ->assertSet('message', lang('igniter.orange::default.contact.alert_contact_sent'));

    Mail::assertQueued(AnonymousTemplateMailable::class, function($mail) {
        return $mail->getTemplateCode() === 'igniter.frontend::mail.contact';
    });
});

it('fails to submit contact form with invalid fields', function() {
    Livewire::test(Contact::class)
        ->set('subject', 'General Enquiry')
        ->set('email', '')
        ->set('fullName', '')
        ->set('telephone', '1234567890')
        ->set('comment', 'This is a test comment.')
        ->call('onSubmit')
        ->assertHasErrors(['email', 'fullName']);
});
