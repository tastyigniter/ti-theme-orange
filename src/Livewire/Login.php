<?php

namespace Igniter\Orange\Livewire;

use Igniter\Main\Traits\ConfigurableComponent;
use Igniter\Main\Traits\UsesPage;
use Igniter\Orange\Livewire\Forms\LoginForm;
use Igniter\User\Actions\LoginUser;
use Igniter\User\Facades\Auth;
use Illuminate\Validation\ValidationException;

class Login extends \Livewire\Component
{
    use ConfigurableComponent;
    use UsesPage;

    public LoginForm $form;

    public bool $registrationAllowed = true;

    public string $redirectPage = 'account.account';

    public static function componentMeta(): array
    {
        return [
            'code' => 'igniter-orange::login',
            'name' => 'igniter.orange::default.component_login_title',
            'description' => 'igniter.orange::default.component_login_desc',
        ];
    }

    public function defineProperties()
    {
        return [
            'redirectPage' => [
                'label' => 'Page to redirect to after login.',
                'type' => 'select',
                'options' => [static::class, 'getThemePageOptions'],
                'validationRule' => 'required|regex:/^[a-z0-9\-_\.]+$/i',
            ],
        ];
    }

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

        rescue(function() {
            resolve(LoginUser::class, [
                'credentials' => $this->form->except('remember'),
                'remember' => $this->form->remember,
            ])->handle();
        }, function(\Throwable $e) {
            throw ValidationException::withMessages(['form.email' => $e->getMessage()]);
        });

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
