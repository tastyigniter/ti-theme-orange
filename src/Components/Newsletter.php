<?php

namespace Igniter\Orange\Components;

use DrewM\MailChimp\MailChimp;
use Exception;
use Igniter\Admin\Traits\ValidatesForm;
use Igniter\Flame\Exception\ApplicationException;
use Igniter\Frontend\Models\MailchimpSettings;
use Igniter\Frontend\Models\Subscriber;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;

class Newsletter extends \Igniter\System\Classes\BaseComponent
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
        if (!MailChimpSettings::isConfigured()) {
            throw new ApplicationException('MailChimp List ID is missing. Enter your mailchimp api key and list ID from the admin settings page');
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
            $listId = $this->property('listId', MailChimpSettings::get('list_id'));

            $response = resolve(MailChimp::class)->post("lists/$listId/members", $options);

            $errorMessage = array_get($response, 'detail', '');
            if (strlen($errorMessage) && array_get($response, 'status') !== 200) {
                Log::error($response);
            }
        } catch (Exception $e) {
            throw new ApplicationException('MailChimp returned the following error: '.$e->getMessage());
        }
    }
}
