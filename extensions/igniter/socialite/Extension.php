<?php

namespace Igniter\Socialite;

use Admin\Widgets\Form;
use Igniter\Socialite\Classes\ProviderManager;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\Event;
use System\Classes\BaseExtension;

/**
 * Socialite Extension Information File
 */
class Extension extends BaseExtension
{
    public function register()
    {
        $this->app->register(\Laravel\Socialite\SocialiteServiceProvider::class);
        AliasLoader::getInstance()->alias('Socialite', \Laravel\Socialite\Facades\Socialite::class);
    }

    public function boot()
    {
        $this->extendSettingsFormField();
    }

    public function registerSettings()
    {
        return [
            'settings' => [
                'label' => 'Configure Social Login Providers',
                'description' => 'Configure social login providers with API credentials.',
                'icon' => 'fa fa-users',
                'model' => \Igniter\Socialite\Models\Settings::class,
                'priority' => 700,
            ],
        ];
    }

    public function registerSocialiteProviders()
    {
        return [
            \Igniter\Socialite\SocialiteProviders\Facebook::class => [
                'code' => 'facebook',
                'label' => 'Facebook',
                'description' => 'Log in with Facebook',
            ],
            \Igniter\Socialite\SocialiteProviders\Google::class => [
                'code' => 'google',
                'label' => 'Google',
                'description' => 'Log in with Google',
            ],
            \Igniter\Socialite\SocialiteProviders\Twitter::class => [
                'code' => 'twitter',
                'label' => 'Twitter',
                'description' => 'Log in with Twitter',
            ],
        ];
    }

    public function registerComponents()
    {
        return [
            \Igniter\Socialite\Components\Socialite::class => [
                'code' => 'socialite',
                'name' => 'Socialite component',
                'description' => 'Displays the social networks login buttons',
            ],
        ];
    }

    protected function extendSettingsFormField()
    {
        Event::listen('admin.form.extendFields', function (Form $form) {
            if (!$form->getController() instanceof \System\Controllers\Extensions) {
                return;
            }
            if (!$form->model instanceof \Igniter\Socialite\Models\Settings) {
                return;
            }

            $manager = ProviderManager::instance();
            foreach ($manager->listProviders() as $class => $details) {
                $provider = $manager->makeProvider($class, $details);
                $provider->extendSettingsForm($form);
            }
        });
    }
}
