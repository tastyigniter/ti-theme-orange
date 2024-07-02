<?php

namespace Igniter\Orange\Tests\Livewire;

use Igniter\Orange\Livewire\NewsletterSubscribeForm;
use Livewire\Livewire;

it('mounts and prepare props', function() {
    Livewire::test(NewsletterSubscribeForm::class)
        ->assertSet('listId', null)
        ->assertSet('email', null)
        ->assertSet('message', null);
});

it('subscribes to newsletter', function() {
    Livewire::test(NewsletterSubscribeForm::class)
        ->set('email', 'test@example.com')
        ->call('onSubscribe')
        ->assertHasNoErrors();
});

it('handles subscription exception', function() {
    Livewire::test(NewsletterSubscribeForm::class)
        ->set('email', 'invalid-email')
        ->call('onSubscribe')
        ->assertHasErrors(['email']);
});

it('resets form', function() {
    Livewire::test(NewsletterSubscribeForm::class)
        ->set('email', 'test@example.com')
        ->call('onSubscribe')
        ->assertSet('email', null)
        ->assertNotSet('message', null);
});
