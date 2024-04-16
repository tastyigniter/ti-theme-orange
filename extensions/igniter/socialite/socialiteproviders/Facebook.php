<?php

namespace Igniter\Socialite\SocialiteProviders;

use Admin\Widgets\Form;
use Igniter\Socialite\Classes\BaseProvider;
use Laravel\Socialite\Two\FacebookProvider;
use Socialite;

class Facebook extends BaseProvider
{
    protected $provider = FacebookProvider::class;

    public function extendSettingsForm(Form $form)
    {
        $form->addFields([
            'setup' => [
                'type' => 'partial',
                'path' => '$/igniter/socialite/socialiteproviders/facebook/info',
                'tab' => 'Facebook',
            ],
            'providers[facebook][status]' => [
                'label' => 'Status',
                'type' => 'switch',
                'default' => true,
                'span' => 'left',
                'tab' => 'Facebook',
            ],
            'providers[facebook][client_id]' => [
                'label' => 'App ID',
                'type' => 'text',
                'tab' => 'Facebook',
            ],
            'providers[facebook][client_secret]' => [
                'label' => 'App Secret',
                'type' => 'text',
                'tab' => 'Facebook',
            ],
        ], 'primary');
    }

    public function redirectToProvider()
    {
        return Socialite::driver($this->driver)->scopes(['email'])->redirect();
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
