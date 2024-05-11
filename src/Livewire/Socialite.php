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
        $manager = resolve(ProviderManager::class);

        if (!$providerData = $manager->getProviderData()) {
            return;
        }

        $validated = $this->validate(post(), [
            ['email', 'lang:igniter.user::default.reset.label_email', 'required|email:filter|max:96|unique:customers,email'],
        ]);

        $providerData['user']->email = $validated['email'];

        $manager->setProviderData($providerData);

        return $manager->completeCallback();
    }

    protected function loadLinks()
    {
        return resolve(ProviderManager::class)->listProviderLinks();
    }
}
