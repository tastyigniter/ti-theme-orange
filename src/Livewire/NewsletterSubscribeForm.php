<?php

namespace Igniter\Orange\Livewire;

use Exception;
use Igniter\Frontend\Models\Subscriber;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Validate;

class NewsletterSubscribeForm extends \Livewire\Component
{
    /** MailChimp List/Audience ID - Overrides the admin settings value */
    public ?string $listId = null;

    #[Validate('required|email:filter|max:96', as: 'igniter.frontend::default.newsletter.label_email')]
    public ?string $email = null;

    public ?string $message = null;

    public function render()
    {
        return view('igniter-orange::livewire.newsletter-subscribe-form');
    }

    public function onSubscribe()
    {
        $this->validate();

        try {
            $subscribe = Subscriber::subscribe($this->listId, $this->email);
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
