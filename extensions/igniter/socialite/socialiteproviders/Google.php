<?php

namespace Igniter\Socialite\SocialiteProviders;

use Admin\Widgets\Form;
use Igniter\Socialite\Classes\BaseProvider;
use Laravel\Socialite\Two\GoogleProvider;
use Socialite;

class Google extends BaseProvider
{
    protected $provider = GoogleProvider::class;

    public function extendSettingsForm(Form $form)
    {
        $form->addFields([
            'setup' => [
                'type' => 'partial',
                'path' => '$/igniter/socialite/socialiteproviders/google/info',
                'tab' => 'Google',
            ],
            'providers[google][status]' => [
                'label' => 'Status',
                'type' => 'switch',
                'default' => true,
                'span' => 'left',
                'tab' => 'Google',
            ],
            'providers[google][app_name]' => [
                'label' => 'Application Name',
                'type' => 'text',
                'default' => 'Social Login',
                'comment' => 'This appears on the Google login screen. Usually your site name.',
                'tab' => 'Google',
            ],
            'providers[google][client_id]' => [
                'label' => 'Client ID',
                'type' => 'text',
                'tab' => 'Google',
            ],
            'providers[google][client_secret]' => [
                'label' => 'Client Secret',
                'type' => 'text',
                'tab' => 'Google',
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
