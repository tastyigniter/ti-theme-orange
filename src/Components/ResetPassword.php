<?php

namespace Igniter\Orange\Components;

use Igniter\Admin\Traits\ValidatesForm;
use Igniter\Flame\Exception\ApplicationException;
use Igniter\Main\Template\Page;
use Igniter\Main\Traits\UsesPage;
use Igniter\System\Classes\BaseComponent;
use Igniter\User\Models\Customer;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;

class ResetPassword extends BaseComponent
{
    use UsesPage;
    use ValidatesForm;

    public function defineProperties()
    {
        return [
            'resetPage' => [
                'label' => 'The reset password page',
                'type' => 'select',
                'default' => 'account'.DIRECTORY_SEPARATOR.'reset',
                'options' => [static::class, 'getThemePageOptions'],
                'validationRule' => 'required|regex:/^[a-z0-9\-_\/]+$/i',
            ],
            'loginPage' => [
                'label' => 'The login page',
                'type' => 'select',
                'default' => 'account'.DIRECTORY_SEPARATOR.'login',
                'options' => [static::class, 'getThemePageOptions'],
                'validationRule' => 'required|regex:/^[a-z0-9\-_\/]+$/i',
            ],
            'paramName' => [
                'label' => 'The parameter name used for the password reset code',
                'type' => 'text',
                'default' => 'code',
                'validationRule' => 'required|string',
            ],
        ];
    }

    public static function getResetPageOptions()
    {
        return Page::lists('baseFileName', 'baseFileName');
    }

    public static function getLoginPageOptions()
    {
        return Page::lists('baseFileName', 'baseFileName');
    }

    /**
     * Returns the reset password code from the URL
     * @return string
     */
    public function resetCode()
    {
        $routeParameter = $this->property('paramName');

        if ($code = $this->param($routeParameter)) {
            return $code;
        }

        return get('reset');
    }

    public function onForgotPassword()
    {
        $namedRules = [
            ['email', 'lang:igniter.user::default.reset.label_email', 'required|email:filter|max:96'],
        ];

        $this->validate(post(), $namedRules);

        if ($customer = Customer::whereEmail(post('email'))->first()) {
            if (!$code = $customer->resetPassword()) {
                throw new ApplicationException(lang('igniter.user::default.reset.alert_reset_error'));
            }

            $link = $this->makeResetUrl($code);
            $this->sendResetPasswordMail($customer, $code, $link);
        }

        flash()->success(lang('igniter.user::default.reset.alert_reset_request_success'));

        return Redirect::back();
    }

    public function onResetPassword()
    {
        $namedRules = [
            ['code', 'lang:igniter.user::default.reset.label_code', 'required'],
            ['password', 'lang:igniter.user::default.reset.label_password', 'required|same:password_confirm'],
            ['password_confirm', 'lang:igniter.user::default.reset.label_password_confirm', 'required'],
        ];

        $this->validate(post(), $namedRules);

        $customer = Customer::whereResetCode($code = post('code'))->first();

        if (!$customer || !$customer->completeResetPassword($code, post('password'))) {
            throw new ApplicationException(lang('igniter.user::default.reset.alert_reset_failed'));
        }

        flash()->success(lang('igniter.user::default.reset.alert_reset_success'));

        return Redirect::to($this->controller->pageUrl($this->property('loginPage')));
    }

    protected function makeResetUrl($code)
    {
        $params = [
            $this->property('paramName') => $code,
        ];

        if ($pageName = $this->property('resetPage')) {
            $url = $this->controller->pageUrl($pageName, $params);
        } else {
            $url = $this->currentPageUrl($params);
        }

        if (strpos($url, $code) === false) {
            $url .= '?reset='.$code;
        }

        return $url;
    }

    protected function sendResetPasswordMail($customer, $code, $link)
    {
        $data = [
            'first_name' => $customer->first_name,
            'last_name' => $customer->last_name,
            'reset_code' => $code,
            'reset_link' => $link,
            'account_login_link' => site_url($this->property('loginPage')),
        ];

        Mail::queueTemplate('igniter.user::mail.password_reset_request', $data, $customer);
    }
}
