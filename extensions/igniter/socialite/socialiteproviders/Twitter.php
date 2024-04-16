<?php

namespace Igniter\Socialite\SocialiteProviders;

use Admin\Widgets\Form;
use Igniter\Socialite\Classes\BaseProvider;
use Laravel\Socialite\One\TwitterProvider;
use League\OAuth1\Client\Server\Twitter as TwitterServer;
use Socialite;

class Twitter extends BaseProvider
{
    protected $provider = TwitterProvider::class;

    protected function buildProvider($config, $app)
    {
        return new $this->provider(
            $app['request'], new TwitterServer($config)
        );
    }

    public function extendSettingsForm(Form $form)
    {
        $form->addFields([
            'setup' => [
                'type' => 'partial',
                'path' => '$/igniter/socialite/socialiteproviders/twitter/info',
                'tab' => 'Twitter',
            ],
            'providers[twitter][status]' => [
                'label' => 'Status',
                'type' => 'switch',
                'default' => true,
                'span' => 'left',
                'tab' => 'Twitter',
            ],
            'providers[twitter][identifier]' => [
                'label' => 'API Key',
                'type' => 'text',
                'tab' => 'Twitter',
            ],

            'providers[twitter][secret]' => [
                'label' => 'API Secret',
                'type' => 'text',
                'tab' => 'Twitter',
            ],
        ], 'primary');
    }

    public function redirectToProvider()
    {
        return Socialite::driver($this->driver)->redirect();
    }

    public function handleProviderCallback()
    {
        return Socialite::driver($this->driver)->user();
    }

    public function shouldConfirmEmail($providerUser)
    {
        return !strlen($providerUser->email);
    }
}
