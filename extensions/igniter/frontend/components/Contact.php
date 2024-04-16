<?php

namespace Igniter\Frontend\Components;

use Admin\Traits\ValidatesForm;
use Exception;
use Igniter\Local\Facades\Location;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Main\Template\Page;
use Main\Traits\UsesPage;
use System\Classes\BaseComponent;

class Contact extends BaseComponent
{
    use UsesPage;
    use ValidatesForm;

    public $location;

    public $subjects;

    public function defineProperties()
    {
        return [
            'redirectPage' => [
                'label' => 'Page to redirect to after contact form has been sent successfully',
                'type' => 'select',
                'default' => 'contact',
                'options' => [static::class, 'getThemePageOptions'],
                'validationRule' => 'required|regex:/^[a-z0-9\-_\/]+$/i',
            ],
        ];
    }

    public static function getRedirectPageOptions()
    {
        return Page::lists('baseFileName', 'baseFileName');
    }

    public function onRun()
    {
        $this->location = Location::getDefault();

        $this->subjects = [
            'igniter.frontend::default.contact.text_general_enquiry',
            'igniter.frontend::default.contact.text_comment',
            'igniter.frontend::default.contact.text_technical_issues',
        ];
    }

    public function onSubmit()
    {
        try {
            $rules = [
                ['subject', 'lang:igniter.frontend::default.contact.text_select_subject', 'required|max:128'],
                ['email', 'lang:igniter.frontend::default.contact.label_email', 'required|email:filter|max:96'],
                ['full_name', 'lang:igniter.frontend::default.contact.label_full_name', 'required|min:2|max:255'],
                ['telephone', 'lang:igniter.frontend::default.contact.label_telephone', 'required'],
                ['comment', 'lang:igniter.frontend::default.contact.label_comment', 'max:1500'],
            ];

            $this->validate(post(), $rules);

            $data = [
                'full_name' => post('full_name'),
                'contact_topic' => post('subject'),
                'contact_email' => post('email'),
                'contact_telephone' => post('telephone'),
                'contact_message' => post('comment'),
            ];

            Mail::queue('igniter.frontend::mail.contact', $data, function ($message) {
                $message->to(setting('site_email'), setting('site_name'));
            });

            flash()->success(lang('igniter.frontend::default.contact.alert_contact_sent'));

            $redirectUrl = $this->controller->pageUrl($this->property('redirectPage'));

            if ($redirectUrl = get('redirect', $redirectUrl)) {
                return Redirect::to($redirectUrl);
            }
        } catch (Exception $ex) {
            flash()->warning($ex->getMessage());

            return Redirect::back()->withInput();
        }
    }
}
