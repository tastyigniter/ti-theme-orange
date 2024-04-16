<?php

namespace Igniter\Socialite\Components;

use Admin\Traits\ValidatesForm;
use Igniter\Socialite\Classes\ProviderManager;
use System\Classes\BaseComponent;

class Socialite extends BaseComponent
{
    use \Main\Traits\UsesPage;
    use ValidatesForm;

    public function defineProperties()
    {
        return [
            'errorPage' => [
                'label' => 'The page to redirect to when an error occurred',
                'type' => 'select',
                'default' => 'account'.DIRECTORY_SEPARATOR.'login',
                'options' => [static::class, 'getThemePageOptions'],
                'validationRule' => 'required|regex:/^[a-z0-9\-_\/]+$/i',
            ],
            'successPage' => [
                'label' => 'The page to redirect to when login is successful',
                'type' => 'select',
                'default' => 'account'.DIRECTORY_SEPARATOR.'account',
                'options' => [static::class, 'getThemePageOptions'],
                'validationRule' => 'required|regex:/^[a-z0-9\-_\/]+$/i',
            ],
            'confirmEmailPage' => [
                'label' => 'The page to redirect to when an email address is missing',
                'type' => 'select',
                'default' => 'account'.DIRECTORY_SEPARATOR.'socialite',
                'options' => [static::class, 'getThemePageOptions'],
                'validationRule' => 'required|regex:/^[a-z0-9\-_\/]+$/i',
            ],
        ];
    }

    public function onRun()
    {
        $this->page['errorPage'] = $this->controller->pageUrl($this->property('errorPage'));
        $this->page['successPage'] = $this->controller->pageUrl($this->property('successPage'));

        $this->page['socialiteLinks'] = $this->loadLinks();
    }

    public function onConfirmEmail()
    {
        if (!$sessionData = session()->get('igniter_socialite_provider')) {
            return;
        }

        $validated = $this->validate(post(), [
            ['email', 'lang:igniter.user::default.reset.label_email', 'required|email:filter|max:96|unique:customers,email'],
        ]);

        $sessionData['user']->email = $validated['email'];

        session()->put('igniter_socialite_provider', $sessionData);

        return ProviderManager::instance()->completeCallback();
    }

    protected function loadLinks()
    {
        $result = [];
        $manager = ProviderManager::instance();
        $providers = $manager->listProviders();
        foreach ($providers as $className => $info) {
            $provider = $manager->makeProvider($className, $info);
            if ($provider->isEnabled()) {
                $result[$info['code']] = $provider->makeEntryPointUrl('auth');
            }
        }

        return $result;
    }
}
