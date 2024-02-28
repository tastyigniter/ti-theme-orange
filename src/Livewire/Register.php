<?php

namespace Igniter\Orange\Livewire;

use Igniter\Flame\Exception\ApplicationException;
use Igniter\Orange\Livewire\Forms\RegisterForm;
use Igniter\User\Actions\RegisterUser;
use Livewire\Attributes\Url;

class Register extends \Livewire\Component
{
    use \Igniter\Main\Traits\UsesPage;

    public RegisterForm $form;

    #[Url(as: 'code')]
    public string $activationCode = '';

    public string $activationPage = 'account'.DIRECTORY_SEPARATOR.'register';

    public string $agreeTermsSlug = 'null';

    public bool $requireRegistrationTerms = false;

    public bool $registrationAllowed = true;

    public string $redirectPage = 'account'.DIRECTORY_SEPARATOR.'account';

    public string $registerPage = 'account'.DIRECTORY_SEPARATOR.'register';

    public string $loginPage = 'account'.DIRECTORY_SEPARATOR.'login';

    public function render()
    {
        return view('igniter-orange::livewire.register');
    }

    public function mount()
    {
        $this->registrationAllowed = (bool)setting('allow_registration', true);
        $this->requireRegistrationTerms = !empty($this->agreeTermsSlug);

        if ($this->activationCode) {
            $this->onActivate();
        }
    }

    public function onRegister()
    {
        throw_unless($this->registrationAllowed,
            new ApplicationException(lang('igniter.user::default.login.alert_registration_disabled')));

        $this->form->validate();

        $action = resolve(RegisterUser::class);
        $customer = $action->handle($this->form->except(['password_confirm', 'terms']));

        if ($customer->is_activated) {
            $action->notifyRegistered(['account_login_link' => page_url($this->loginPage)]);
        } else {
            $action->notifyActivated([
                'account_activation_link' => page_url($this->registerPage).'?code='.$customer->getActivationCode(),
            ]);
        }

        $redirectUrl = page_url($customer->is_activated ? $this->redirectPage : $this->loginPage);
        flash()->success(lang($customer->is_activated
            ? 'igniter.user::default.login.alert_account_created'
            : 'igniter.user::default.login.alert_account_activation'
        ));

        if ($redirectUrl = get('redirect', $redirectUrl)) {
            return redirect()->intended($redirectUrl);
        }
    }

    public function onActivate()
    {
        $this->validate([
            'activationCode' => ['required', 'string'],
        ], [], [
            'code' => lang('igniter.user::default.reset.alert_no_activation_code'),
        ]);

        resolve(RegisterUser::class)->activate($this->activationCode);

        return redirect()->to(page_url($this->redirectPage));
    }
}
