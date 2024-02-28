<?php

namespace Igniter\Orange\Livewire;

use DrewM\MailChimp\MailChimp;
use Exception;
use Igniter\Flame\Exception\ApplicationException;
use Igniter\Frontend\Models\MailchimpSettings;
use Igniter\Frontend\Models\Subscriber;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
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

        $data = ['email' => $this->email];

        $subscribe = Subscriber::firstOrCreate($data);

        $this->listSubscribe($subscribe, $data);

        Event::fire('igniter.frontend.subscribed', [$subscribe, $data]);

        $this->reset();

        if (!$subscribe->wasRecentlyCreated) {
            $this->message = lang('igniter.frontend::default.newsletter.alert_success_existing');
        } else {
            $this->message = lang('igniter.frontend::default.newsletter.alert_success_subscribed');
        }
    }

    protected function listSubscribe($subscribe, $data)
    {
        if (!MailChimpSettings::isConfigured()) {
            throw ValidationException::withMessages(['email' => 'MailChimp List ID is missing. Enter your mailchimp api key and list ID from the admin settings page']);
        }

        $options = [
            'email_address' => $subscribe->email,
            'status' => 'subscribed',
            'email_type' => 'html',
        ];

        if (isset($data['merge']) && is_array($data['merge']) && count($data['merge'])) {
            $options['merge_fields'] = $data['merge'];
        }

        try {
            $listId = $this->listId ?? (string)MailChimpSettings::get('list_id');

            $response = resolve(MailChimp::class)->post("lists/$listId/members", $options);

            $errorMessage = array_get($response, 'detail', '');

            throw_if(strlen($errorMessage) && array_get($response, 'status') !== 200, new ApplicationException($errorMessage));
        } catch (Exception $e) {
            Log::error($e);

            throw ValidationException::withMessages(['email' => 'MailChimp returned the following error: '.$e->getMessage()]);
        }
    }
}
