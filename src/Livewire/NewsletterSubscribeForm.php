<?php

namespace Igniter\Orange\Livewire;

use Exception;
use Igniter\Frontend\Models\Subscriber;
use Igniter\Main\Traits\ConfigurableComponent;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Validate;

class NewsletterSubscribeForm extends \Livewire\Component
{
    use ConfigurableComponent;

    /** MailChimp List/Audience ID - Overrides the admin settings value */
    public ?string $listId = null;

    #[Validate('required|email:filter|max:96', as: 'igniter.frontend::default.newsletter.label_email')]
    public ?string $email = null;

    public ?string $message = null;

    public static function componentMeta(): array
    {
        return [
            'code' => 'igniter-orange::newsletter-subscribe-form',
            'name' => 'igniter.orange::default.component_newsletter_subscribe_form_title',
            'description' => 'igniter.orange::default.component_newsletter_subscribe_form_desc',
        ];
    }

    public function defineProperties()
    {
        return [
            'listId' => [
                'label' => 'The Mailchimp list ID to subscribe users to.',
                'type' => 'text',
                'validationRule' => 'nullable|string|max:255',
            ],
        ];
    }

    public function render()
    {
        return view('igniter-orange::livewire.newsletter-subscribe-form');
    }

    public function onSubscribe()
    {
        $this->validate();

        try {
            $subscribe = Subscriber::subscribe($this->email, $this->listId);
        } catch (Exception $e) {
            throw ValidationException::withMessages(['email' => $e->getMessage()]);
        }
        $this->reset();

        if (!$subscribe->wasRecentlyCreated) {
            $this->message = lang('igniter.frontend::default.newsletter.alert_success_existing');
        } else {
            $this->message = lang('igniter.frontend::default.newsletter.alert_success_subscribed');
        }
    }
}
