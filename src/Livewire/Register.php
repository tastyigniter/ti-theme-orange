<?php

declare(strict_types=1);

namespace Igniter\Orange\Livewire;

use Igniter\Flame\Exception\ApplicationException;
use Igniter\Main\Traits\ConfigurableComponent;
use Igniter\Main\Traits\UsesPage;
use Igniter\Orange\Livewire\Forms\RegisterForm;
use Igniter\User\Actions\RegisterCustomer;
use Livewire\Attributes\Url;
use Livewire\Component;

final class Register extends Component
{
    use ConfigurableComponent;
    use UsesPage;

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

    public function defineProperties(): array
    {
        return [
            'agreeTermsSlug' => [
                'label' => 'Page to redirect to after registration.',
                'type' => 'select',
                'options' => self::getStaticPageOptions(...),
                'comment' => 'If set, require customers to agree to terms before registering',
                'validationRule' => 'sometimes|alpha_dash',
            ],
            'redirectPage' => [
                'label' => 'Static page for the registration terms and conditions.',
                'type' => 'select',
                'options' => self::getThemePageOptions(...),
                'validationRule' => 'required|regex:/^[a-z0-9\-_\.]+$/i',
            ],
            'activationPage' => [
                'label' => 'Page to redirect to when the user clicks the activation link.',
                'type' => 'select',
                'options' => self::getThemePageOptions(...),
                'validationRule' => 'required|regex:/^[a-z0-9\-_\.]+$/i',
            ],
            'loginPage' => [
                'label' => 'Page to redirect to when the user clicks the login button.',
                'type' => 'select',
                'options' => self::getThemePageOptions(...),
                'validationRule' => 'required|regex:/^[a-z0-9\-_\.]+$/i',
            ],
        ];
    }

    public function render()
    {
        return view('igniter-orange::livewire.register');
    }

    public function mount(): void
    {
        $this->registrationAllowed = (bool)setting('allow_registration', true);
        $this->requireRegistrationTerms = $this->agreeTermsSlug !== null && strlen($this->agreeTermsSlug) > 0;

        if (strlen($this->activationCode) > 0) {
            $this->onActivate();
        }
    }

    public function onRegister()
    {
        throw_unless($this->registrationAllowed,
            new ApplicationException(lang('igniter.user::default.login.alert_registration_disabled')));

        $this->form->validate();

        $action = resolve(RegisterCustomer::class);
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
            : 'igniter.user::default.login.alert_account_activation',
        ));

        return redirect()->intended(get('redirect', $redirectUrl));
    }

    public function onActivate()
    {
        $this->validate([
            'activationCode' => ['required', 'string'],
        ], [], [
            'code' => lang('igniter.user::default.reset.alert_no_activation_code'),
        ]);

        $action = resolve(RegisterCustomer::class);
        $customer = $action->activate($this->activationCode);

        $customer->mailSendRegistration(['account_login_link' => page_url($this->loginPage)]);

        return redirect()->to(page_url($this->redirectPage));
    }
}
