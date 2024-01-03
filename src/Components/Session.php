<?php

namespace Igniter\Orange\Components;

use Igniter\System\Classes\BaseComponent;
use Igniter\User\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;

class Session extends BaseComponent
{
    use \Igniter\Main\Traits\UsesPage;

    public function initialize()
    {
        if (Request::ajax() && !$this->checkSecurity()) {
            abort(403, 'Access denied');
        }
    }

    public function defineProperties()
    {
        return [
            'security' => [
                'label' => 'Who can access this page (all, customer or guest)',
                'type' => 'text',
                'default' => 'all',
                'validationRule' => 'required|in:all,customer,guest',
            ],
            'loginPage' => [
                'label' => 'The account login page',
                'type' => 'select',
                'default' => 'account'.DIRECTORY_SEPARATOR.'login',
                'options' => [static::class, 'getThemePageOptions'],
                'validationRule' => 'required|regex:/^[a-z0-9\-_\/]+$/i',
            ],
            'redirectPage' => [
                'label' => 'Page name to redirect to when access is restricted',
                'type' => 'select',
                'default' => 'home',
                'options' => [static::class, 'getThemePageOptions'],
                'validationRule' => 'required|regex:/^[a-z0-9\-_\/]+$/i',
            ],
        ];
    }

    public function onRun()
    {
        if (!$this->checkSecurity()) {
            return Redirect::guest($this->controller->pageUrl($this->property('redirectPage')));
        }

        $this->page['customer'] = $this->customer();
    }

    public function customer()
    {
        if (!Auth::check()) {
            return null;
        }

        return Auth::getUser();
    }

    public function loginUrl()
    {
        $currentUrl = str_replace(Request::root(), '', Request::fullUrl());

        return $this->controller->pageUrl($this->property('loginPage')).'?redirect='.urlencode($currentUrl);
    }

    public function onLogout()
    {
        $user = Auth::getUser();

        Auth::logout();

        session()->invalidate();

        session()->regenerateToken();

        if ($user) {
            Event::fire('igniter.user.logout', [$user]);
        }

        $url = post('redirect', Request::fullUrl());

        flash()->success(lang('igniter.user::default.alert_logout_success'));

        return Redirect::to($url);
    }

    protected function checkSecurity()
    {
        $allowedGroup = $this->property('security', 'all');
        $isAuthenticated = Auth::check();
        if ($allowedGroup == 'customer' && !$isAuthenticated) {
            return false;
        }

        if ($allowedGroup == 'guest' && $isAuthenticated) {
            return false;
        }

        return true;
    }
}
