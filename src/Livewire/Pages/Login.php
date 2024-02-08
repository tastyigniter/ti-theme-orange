<?php

namespace Igniter\Orange\Livewire\Pages;

use Igniter\User\Actions\LoginUser;
use Igniter\User\Facades\Auth;
use Igniter\Orange\Livewire\Forms\LoginForm;

class Login extends \Livewire\Component
{
    use \Igniter\Main\Traits\UsesPage;

    public LoginForm $form;

    public bool $canRegister = true;

    public string $redirectPage = 'account'.DIRECTORY_SEPARATOR.'account';

    private LoginUser $loginUser;

    public function render()
    {
        return view('igniter-orange::livewire.pages.login');
    }

    public function mount()
    {
        $this->canRegister = (bool)setting('allow_registration', true);
    }

    public function customer()
    {
        if (!Auth::check()) {
            return null;
        }

        return Auth::getUser();
    }

    public function onLogin()
    {
        $this->form->validate();

        resolve(LoginUser::class, [
            'credentials' => $this->form->except('remember'),
            'remember' => $this->form->remember,
        ])->handle();

        if ($redirect = input('redirect')) {
            return redirect()->to(page_url($redirect));
        }

        if ($redirectUrl = page_url($this->redirectPage)) {
            return redirect()->intended($redirectUrl);
        }
    }
}
