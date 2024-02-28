<?php

namespace Igniter\Orange\Livewire;

use Igniter\Socialite\Classes\ProviderManager;
use Livewire\Component;

class Socialite extends Component
{
    public string $errorPage = 'account'.DIRECTORY_SEPARATOR.'login';

    public string $successPage = 'account'.DIRECTORY_SEPARATOR.'account';

    public string $confirmEmailPage = 'account'.DIRECTORY_SEPARATOR.'socialite';

    public bool $confirm = false;

    public array $links = [];

    public function render()
    {
        return view('igniter-orange::livewire.socialite');
    }

    public function mount()
    {
        $this->links = $this->loadLinks();
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

        return resolve(ProviderManager::class)->completeCallback();
    }

    protected function loadLinks()
    {
        $result = [];
        $manager = resolve(ProviderManager::class);
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
