<?php

declare(strict_types=1);

namespace Igniter\Orange\Tests\Livewire;

use Exception;
use DrewM\MailChimp\MailChimp;
use Igniter\Frontend\Models\MailchimpSettings;
use Igniter\Frontend\Models\Subscriber;
use Igniter\Main\Traits\ConfigurableComponent;
use Igniter\Orange\Livewire\NewsletterSubscribeForm;
use Livewire\Livewire;

it('initialize component correctly', function(): void {
    $component = new NewsletterSubscribeForm;

    expect(class_uses_recursive($component))
        ->toContain(ConfigurableComponent::class)
        ->and($component->listId)->toBeNull()
        ->and($component->email)->toBeNull()
        ->and($component->message)->toBeNull();
});

it('returns correct component meta', function(): void {
    $meta = NewsletterSubscribeForm::componentMeta();

    expect($meta['code'])->toBe('igniter-orange::newsletter-subscribe-form')
        ->and($meta['name'])->toBe('igniter.orange::default.component_newsletter_subscribe_form_title')
        ->and($meta['description'])->toBe('igniter.orange::default.component_newsletter_subscribe_form_desc');
});

it('defines properties correctly', function(): void {
    $component = new NewsletterSubscribeForm;
    $properties = $component->defineProperties();

    expect(array_keys($properties))->toContain('listId');
});

it('mounts and prepare props', function(): void {
    Livewire::test(NewsletterSubscribeForm::class)
        ->assertSet('listId', null)
        ->assertSet('email', null)
        ->assertSet('message', null);
});

it('subscribes new email to newsletter', function(): void {
    Livewire::test(NewsletterSubscribeForm::class)
        ->set('email', 'test@example.com')
        ->call('onSubscribe')
        ->assertHasNoErrors()
        ->assertSet('email', null)
        ->assertSet('message', lang('igniter.frontend::default.newsletter.alert_success_subscribed'));
});

it('subscribes existing email to newsletter', function(): void {
    Subscriber::subscribe('test@example.com');

    Livewire::test(NewsletterSubscribeForm::class)
        ->set('email', 'test@example.com')
        ->call('onSubscribe')
        ->assertHasNoErrors()
        ->assertSet('email', null)
        ->assertSet('message', lang('igniter.frontend::default.newsletter.alert_success_existing'));
});

it('handles mailchimp subscription exception', function(): void {
    MailchimpSettings::set('api_key', 'api-key');
    MailchimpSettings::set('list_id', 'list-id');
    $mailchimp = mock(MailChimp::class);
    $mailchimp->shouldReceive('post')->andThrow(new Exception('Mailchimp error'));
    app()->instance(MailChimp::class, $mailchimp);

    Livewire::test(NewsletterSubscribeForm::class)
        ->set('listId', 'list-id')
        ->set('email', 'test@example.com')
        ->call('onSubscribe')
        ->assertHasErrors(['email']);
});
