<?php

namespace Igniter\Orange\Components;

use Igniter\Admin\Traits\ValidatesForm;
use Igniter\Cart\Facades\Cart;
use Igniter\Flame\Exception\ApplicationException;
use Igniter\User\Actions\LoginUser;
use Igniter\User\Actions\RegisterUser;
use Igniter\User\Facades\Auth;
use Igniter\User\Models\Customer;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;

class Account extends \Igniter\System\Classes\BaseComponent
{
    use \Igniter\Main\Traits\UsesPage;
    use ValidatesForm;

    public function defineProperties(): array
    {
        return [
            'accountPage' => [
                'label' => 'The customer dashboard page',
                'type' => 'select',
                'default' => 'account'.DIRECTORY_SEPARATOR.'account',
                'options' => [static::class, 'getThemePageOptions'],
                'validationRule' => 'required|regex:/^[a-z0-9\-_\/]+$/i',
            ],
            'addressPage' => [
                'label' => 'The customer address page',
                'type' => 'select',
                'default' => 'account'.DIRECTORY_SEPARATOR.'address',
                'options' => [static::class, 'getThemePageOptions'],
                'validationRule' => 'required|regex:/^[a-z0-9\-_\/]+$/i',
            ],
            'ordersPage' => [
                'label' => 'The customer orders page',
                'type' => 'select',
                'default' => 'account'.DIRECTORY_SEPARATOR.'orders',
                'options' => [static::class, 'getThemePageOptions'],
                'validationRule' => 'required|regex:/^[a-z0-9\-_\/]+$/i',
            ],
            'reservationsPage' => [
                'label' => 'The customer reservations page',
                'type' => 'select',
                'default' => 'account'.DIRECTORY_SEPARATOR.'reservations',
                'options' => [static::class, 'getThemePageOptions'],
                'validationRule' => 'required|regex:/^[a-z0-9\-_\/]+$/i',
            ],
            'reviewsPage' => [
                'label' => 'The customer reviews page',
                'type' => 'select',
                'default' => 'account'.DIRECTORY_SEPARATOR.'reviews',
                'options' => [static::class, 'getThemePageOptions'],
                'validationRule' => 'required|regex:/^[a-z0-9\-_\/]+$/i',
            ],
            'inboxPage' => [
                'label' => 'The customer inbox page',
                'type' => 'select',
                'default' => 'account'.DIRECTORY_SEPARATOR.'inbox',
                'options' => [static::class, 'getThemePageOptions'],
                'validationRule' => 'required|regex:/^[a-z0-9\-_\/]+$/i',
            ],
            'loginPage' => [
                'label' => 'The account login page',
                'type' => 'select',
                'default' => 'account'.DIRECTORY_SEPARATOR.'login',
                'options' => [static::class, 'getThemePageOptions'],
                'validationRule' => 'required|regex:/^[a-z0-9\-_\/]+$/i',
            ],
            'activationPage' => [
                'label' => 'The account registration activation page',
                'type' => 'select',
                'default' => 'account'.DIRECTORY_SEPARATOR.'register',
                'options' => [static::class, 'getThemePageOptions'],
                'validationRule' => 'required|regex:/^[a-z0-9\-_\/]+$/i',
            ],
            'agreeRegistrationTermsPage' => [
                'label' => 'Registration Terms',
                'type' => 'select',
                'options' => [static::class, 'getStaticPageOptions'],
                'placeholder' => 'lang:admin::lang.text_please_select',
                'comment' => 'Require customers to agree to terms before an account is registered',
                'validationRule' => 'integer',
            ],
            'redirectPage' => [
                'label' => 'Page to redirect to after successful login or registration',
                'type' => 'select',
                'default' => 'account'.DIRECTORY_SEPARATOR.'account',
                'options' => [static::class, 'getThemePageOptions'],
                'validationRule' => 'required|regex:/^[a-z0-9\-_\/]+$/i',
            ],
        ];
    }

    public function onRun()
    {
        if ($code = $this->getActivationCode()) {
            $this->onActivate($code);
        }

        $this->prepareVars();
    }

    public function prepareVars()
    {
        $this->page['accountPage'] = $this->property('accountPage');
        $this->page['detailsPage'] = $this->property('detailsPage');
        $this->page['addressPage'] = $this->property('addressPage');
        $this->page['ordersPage'] = $this->property('ordersPage');
        $this->page['reservationsPage'] = $this->property('reservationsPage');
        $this->page['reviewsPage'] = $this->property('reviewsPage');
        $this->page['inboxPage'] = $this->property('inboxPage');
        $this->page['requireRegistrationTerms'] = (bool)$this->property('agreeRegistrationTermsPage');
        $this->page['canRegister'] = (bool)setting('allow_registration', true);

        $this->page['customer'] = $this->customer();
    }

    public function cartCount()
    {
        return Cart::count();
    }

    public function cartTotal()
    {
        return Cart::total();
    }

    public function getRegistrationTermsPageSlug()
    {
        return $this->getStaticPagePermalink($this->property('agreeRegistrationTermsPage'));
    }

    public function getRegistrationTermsUrl()
    {
        return url($this->getRegistrationTermsPageSlug());
    }

    public function customer()
    {
        if (!Auth::check()) {
            return null;
        }

        return Auth::getUser();
    }

    public function getCustomerOrders()
    {
        return $this->customer()->orders()->with('status')->take(10)->get();
    }

    public function getCustomerReservations()
    {
        return $this->customer()->reservations()->with('status')->take(10)->get();
    }

    public function onLogin()
    {
        $namedRules = [
            ['email', 'lang:igniter.user::default.settings.label_email', 'required|email:filter|max:96'],
            ['password', 'lang:igniter.user::default.login.label_password', 'required|min:8|max:40'],
            ['remember', 'lang:igniter.user::default.login.label_remember', 'integer'],
        ];

        $this->validate(post(), $namedRules);

        resolve(LoginUser::class, [
            'credentials' => [
                'email' => post('email'),
                'password' => post('password'),
            ],
            'remember' => (bool)post('remember'),
        ])->handle();

        if ($redirect = input('redirect')) {
            return Redirect::to($this->controller->pageUrl($redirect));
        }

        if ($redirectUrl = $this->controller->pageUrl($this->property('redirectPage'))) {
            return Redirect::intended($redirectUrl);
        }
    }

    public function onRegister()
    {
        if (!(bool)setting('allow_registration', true)) {
            throw new ApplicationException(lang('igniter.user::default.login.alert_registration_disabled'));
        }

        $rules = [
            ['first_name', 'lang:igniter.user::default.settings.label_first_name', 'required|between:1,48'],
            ['last_name', 'lang:igniter.user::default.settings.label_last_name', 'required|between:1,48'],
            ['email', 'lang:igniter.user::default.settings.label_email', 'required|email:filter|max:96|unique:customers,email'],
            ['password', 'lang:igniter.user::default.login.label_password', 'required|min:6|max:32|same:password_confirm'],
            ['password_confirm', 'lang:igniter.user::default.login.label_password_confirm', 'required'],
            ['telephone', 'lang:igniter.user::default.settings.label_telephone', 'required'],
            ['newsletter', 'lang:igniter.user::default.login.label_subscribe', 'integer'],
        ];

        if (strlen($this->getRegistrationTermsPageSlug())) {
            $rules[] = ['terms', 'lang:igniter.user::default.login.label_i_agree', 'required|integer'];
        }

        $data = $this->validate(post(), $rules);
        $data['status'] = true;

        $action = resolve(RegisterUser::class);
        $customer = $action->handle(array_except($data, ['password_confirm', 'terms']));

        if ($customer->is_activated) {
            $action->notifyRegistered(['account_login_link' => page_url($this->property('loginPage'))]);
        } else {
            $action->notifyActivated([
                'account_activation_link' => $this->makeActivationUrl($customer->getActivationCode()),
            ]);
        }

        $redirectUrl = $customer->is_activated
            ? $this->controller->pageUrl($this->property('redirectPage'))
            : $this->controller->pageUrl($this->property('loginPage'));

        flash()->success(lang($customer->is_activated
            ? 'igniter.user::default.login.alert_account_created'
            : 'igniter.user::default.login.alert_account_activation'
        ));

        if ($redirectUrl = get('redirect', $redirectUrl)) {
            return Redirect::intended($redirectUrl);
        }
    }

    public function onUpdate()
    {
        if (!$customer = $this->customer()) {
            return;
        }

        $rules = [
            ['first_name', 'lang:igniter.user::default.settings.label_first_name', 'required|between:1,48'],
            ['last_name', 'lang:igniter.user::default.settings.label_last_name', 'required|between:1,48'],
            ['telephone', 'lang:igniter.user::default.settings.label_telephone', 'required'],
            ['newsletter', 'lang:igniter.user::default.login.label_subscribe', 'integer'],
        ];

        $data = $this->validate(post(), $rules);

        if (!array_key_exists('newsletter', $data)) {
            $data['newsletter'] = 0;
        }

        $customer->fill($data);
        $customer->save();

        flash()->success(lang('igniter.user::default.settings.alert_updated_success'));

        return Redirect::back();
    }

    public function onChangePassword()
    {
        if (!$customer = $this->customer()) {
            return;
        }

        $rules = [
            ['old_password', 'lang:igniter.user::default.settings.label_password', 'required'],
            ['new_password', 'lang:igniter.user::default.settings.label_password', 'required_with:old_password|min:6|max:32|same:confirm_new_password'],
            ['confirm_new_password', 'lang:igniter.user::default.settings.label_password_confirm', 'required_with:old_password'],
        ];

        $this->validateAfter(function ($validator) {
            if ($message = $this->passwordDoesNotMatch()) {
                $validator->errors()->add('old_password', $message);
            }
        });

        $data = $this->validate(post(), $rules);

        $customer->fill(['password' => $data['new_password']]);
        $customer->save();

        Auth::logout();

        session()->invalidate();
        session()->regenerateToken();

        flash()->success(lang('igniter.user::default.settings.alert_updated_success'));

        return Redirect::back();
    }

    public function onActivate($code = null)
    {
        $code = post('code', $code);

        $namedRules = [
            ['code', 'lang:igniter.user::default.login.label_activation', 'required'],
        ];

        $this->validate(['code' => $code], $namedRules);

        $customer = Customer::whereActivationCode($code)->first();
        if (!$customer || !$customer->completeActivation($code)) {
            throw new ApplicationException(lang('igniter.user::default.reset.alert_activation_failed'));
        }

        $this->sendRegistrationEmail($customer);

        Auth::login($customer);

        $redirectUrl = $this->controller->pageUrl($this->property('accountPage'));

        return Redirect::to($redirectUrl);
    }

    public function getActivationCode()
    {
        $param = $this->property('paramCode');
        if ($param && $code = $this->param($param)) {
            return $code;
        }

        return input('activate');
    }

    protected function sendRegistrationEmail($customer)
    {
        $data = [
            'first_name' => $customer->first_name,
            'last_name' => $customer->last_name,
            'account_login_link' => $this->controller->pageUrl($this->property('loginPage')),
        ];

        $settingRegistrationEmail = setting('registration_email');
        is_array($settingRegistrationEmail) || $settingRegistrationEmail = [];

        if (in_array('customer', $settingRegistrationEmail)) {
            Mail::queueTemplate('igniter.user::mail.registration', $data, $customer);
        }

        if (in_array('admin', $settingRegistrationEmail)) {
            Mail::queueTemplate('igniter.user::mail.registration_alert', $data, [setting('site_email'), setting('site_name')]);
        }
    }

    protected function passwordDoesNotMatch()
    {
        if (!strlen($password = post('old_password'))) {
            return false;
        }

        $credentials = ['password' => $password];
        if (!Auth::validateCredentials($this->customer(), $credentials)) {
            return 'Password does not match';
        }

        return false;
    }

    protected function sendActivationEmail($customer)
    {
        $link = $this->makeActivationUrl($customer->getActivationCode());
        $data = [
            'first_name' => $customer->first_name,
            'last_name' => $customer->last_name,
            'account_activation_link' => $link,
        ];

        Mail::queueTemplate('igniter.user::mail.activation', $data, $customer);
    }

    protected function makeActivationUrl($code)
    {
        $params = [
            $this->property('paramName') => $code,
        ];

        $url = ($pageName = $this->property('activationPage'))
            ? $this->controller->pageUrl($pageName, $params)
            : $this->controller->currentPageUrl($params);

        if (strpos($url, $code) === false) {
            $url .= '?activate='.$code;
        }

        return $url;
    }
}
