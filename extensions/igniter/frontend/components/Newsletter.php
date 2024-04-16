<?php

namespace Igniter\Frontend\Components;

use Admin\Traits\ValidatesForm;
use Igniter\Flame\Exception\ApplicationException;
use Igniter\Frontend\Models\MailchimpSettings;
use Igniter\Frontend\Models\Subscriber;
use Illuminate\Support\Facades\Event;
use Mailchimp;

class Newsletter extends \System\Classes\BaseComponent
{
    use ValidatesForm;

    public function defineProperties()
    {
        return [
            'listId' => [
                'label' => 'MailChimp List/Audience ID',
                'type' => 'text',
                'comment' => 'Overrides the admin settings value',
                'validationRule' => 'required|string',
            ],
            'doubleOptIn' => [
                'label' => 'Double Opt-In',
                'type' => 'switch',
                'default' => true,
                'validationRule' => 'required|boolean',
            ],
            'updateExisting' => [
                'label' => 'Update Existing',
                'type' => 'switch',
                'default' => false,
                'validationRule' => 'required|boolean',
            ],
        ];
    }

    public function onRun()
    {
        $this->page['subscribeHandler'] = $this->getEventHandler('onSubscribe');
    }

    public function onSubscribe()
    {
        $data = post();

        $rules = [
            ['subscribe_email', 'lang:igniter.frontend::default.newsletter.label_email', 'required|email:filter|max:96'],
        ];

        $this->validate($data, $rules);

        $subscribe = Subscriber::firstOrNew(['email' => $data['subscribe_email']]);
        $subscribe->fill($data);
        $subscribe->save();

        $this->listSubscribe($subscribe, $data);

        Event::fire('igniter.frontend.subscribed', [$subscribe, $data]);

        if (!$subscribe->wasRecentlyCreated) {
            flash()->success(lang('igniter.frontend::default.newsletter.alert_success_existing'))->now();
        } else {
            flash()->success(lang('igniter.frontend::default.newsletter.alert_success_subscribed'))->now();
        }

        $this->pageCycle();

        return [
            '#notification' => $this->renderPartial('flash'),
        ];
    }

    protected function listSubscribe($subscribe, $data)
    {
        if (!strlen($apiKey = MailChimpSettings::get('api_key'))) {
            return;
        }

        $listId = $this->property('listId', MailChimpSettings::get('list_id'));
        $doubleOptIn = (bool)$this->property('doubleOptIn', true);
        $updateExisting = (bool)$this->property('updateExisting', false);
        $email = ['email' => $subscribe->email];

        $mergeVars = null;
        if (isset($data['merge']) && is_array($data['merge']) && count($data['merge'])) {
            $mergeVars = $data['merge'];
        }

        try {
            $mailchimp = new Mailchimp($apiKey);
            $mailchimp->lists->subscribe(
                $listId, $email, $mergeVars, 'html', $doubleOptIn, $updateExisting
            );
        } catch (\MailChimp_Error $e) {
            throw new ApplicationException('MailChimp returned the following error: '.$e->getMessage());
        }
    }
}
