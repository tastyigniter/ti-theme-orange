<?php

namespace Igniter\Orange\Livewire;

use Igniter\Orange\Livewire\Forms\LoginForm;
use Igniter\User\Actions\LoginUser;
use Igniter\User\Facades\Auth;

class Login extends \Livewire\Component
{
    use \Igniter\Main\Traits\UsesPage;

    public LoginForm $form;

    public bool $registrationAllowed = true;

    public string $redirectPage = 'account'.DIRECTORY_SEPARATOR.'account';

    public function render()
    {
        return view('igniter-orange::livewire.login');
    }

    public function mount()
    {
        $this->registrationAllowed = (bool)setting('allow_registration', true);

        $this->setRedirectIntendedUrl();
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

    protected function setRedirectIntendedUrl()
    {
        $previousUrl = url()->previous();

        if (redirect()->getIntendedUrl()) {
            return;
        }

        if (!$previousUrl || $previousUrl === url()->current() || !str_starts_with($previousUrl, url('/'))) {
            return;
        }

        redirect()->setIntendedUrl($previousUrl);
    }
}
