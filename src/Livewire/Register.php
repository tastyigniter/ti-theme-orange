<?php

namespace Igniter\Orange\Livewire;

use Igniter\Flame\Exception\ApplicationException;
use Igniter\Main\Traits\ConfigurableComponent;
use Igniter\Orange\Livewire\Forms\RegisterForm;
use Igniter\User\Actions\RegisterUser;
use Livewire\Attributes\Url;

class Register extends \Livewire\Component
{
    use ConfigurableComponent;
    use \Igniter\Main\Traits\UsesPage;

    public RegisterForm $form;

    #[Url(as: 'code')]
    public string $activationCode = '';

    public string $activationPage = 'account.register';

    public ?string $agreeTermsSlug = null;

    public bool $requireRegistrationTerms = false;

    public bool $registrationAllowed = true;

    public string $redirectPage = 'account.account';

    public string $loginPage = 'account.login';

    public static function componentMeta(): array
    {
        return [
            'code' => 'igniter-orange::register',
            'name' => 'igniter.orange::default.component_register_title',
            'description' => 'igniter.orange::default.component_register_desc',
        ];
    }

    public function defineProperties()
    {
        return [
            'agreeTermsSlug' => [
                'label' => 'Page to redirect to after registration.',
                'type' => 'select',
                'options' => [static::class, 'getStaticPageOptions'],
                'comment' => 'If set, require customers to agree to terms before registering',
                'validationRule' => 'sometimes|alpha_dash',
            ],
            'redirectPage' => [
                'label' => 'Static page for the registration terms and conditions.',
                'type' => 'select',
                'options' => [static::class, 'getThemePageOptions'],
                'validationRule' => 'required|regex:/^[a-z0-9\-_\.]+$/i',
            ],
            'activationPage' => [
                'label' => 'Page to redirect to when the user clicks the activation link.',
                'type' => 'select',
                'options' => [static::class, 'getThemePageOptions'],
                'validationRule' => 'required|regex:/^[a-z0-9\-_\.]+$/i',
            ],
            'loginPage' => [
                'label' => 'Page to redirect to when the user clicks the login button.',
                'type' => 'select',
                'options' => [static::class, 'getThemePageOptions'],
                'validationRule' => 'required|regex:/^[a-z0-9\-_\.]+$/i',
            ],
        ];
    }

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
            $customer->mailSendRegistration(['account_login_link' => page_url($this->loginPage)]);
        } else {
            $customer->mailSendEmailVerification([
                'account_activation_link' => page_url($this->activationPage).'?code='.$customer->getActivationCode(),
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

        $action = resolve(RegisterUser::class);
        $customer = $action->activate($this->activationCode);

        $customer->mailSendRegistration(['account_login_link' => page_url($this->loginPage)]);

        return redirect()->to(page_url($this->redirectPage));
    }
}
