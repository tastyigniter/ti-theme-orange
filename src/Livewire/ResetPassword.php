<?php

namespace Igniter\Orange\Livewire;

use Igniter\Flame\Exception\ApplicationException;
use Igniter\User\Models\Customer;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class ResetPassword extends Component
{
    /** The reset password page*/
    public string $resetPage = 'account'.DIRECTORY_SEPARATOR.'reset';

    /** The login page*/
    public string $loginPage = 'account'.DIRECTORY_SEPARATOR.'login';

    public ?string $email = null;

    public ?string $resetCode = null;

    public ?string $password = null;

    public ?string $password_confirmation = null;

    public ?string $message = null;

    public function render()
    {
        return view('igniter-orange::livewire.reset-password');
    }

    public function mount()
    {
        $this->resetCode = request()->route()->parameter('code');
    }

    public function onForgotPassword()
    {
        $this->validate([
            'email' => 'required|email:filter|max:96',
        ], [], [
            'email' => lang('igniter.user::default.reset.label_email'),
        ]);

        if ($customer = Customer::whereEmail($this->email)->first()) {
            throw_unless($code = $customer->resetPassword(), ValidationException::withMessages([
                'email' => lang('igniter.user::default.reset.alert_reset_error'),
            ]));

            $link = page_url($this->resetPage, ['code' => $code]);
            $this->sendResetPasswordMail($customer, $code, $link);
        }

        $this->reset();

        $this->message = lang('igniter.user::default.reset.alert_reset_request_success');
    }

    public function onResetPassword()
    {
        $this->validate([
            'resetCode' => 'required',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
        ], [], [
            'resetCode' => lang('igniter.user::default.reset.label_code'),
            'password' => lang('igniter.user::default.reset.label_password'),
            'password_confirmation' => lang('igniter.user::default.reset.label_password_confirm'),
        ]);

        $customer = Customer::whereResetCode($this->resetCode)->first();

        if (!$customer || !$customer->completeResetPassword($this->resetCode, $this->password)) {
            throw new ApplicationException(lang('igniter.user::default.reset.alert_reset_failed'));
        }

        flash()->success(lang('igniter.user::default.reset.alert_reset_success'));

        return $this->redirect(page_url($this->loginPage));
    }

    protected function sendResetPasswordMail($customer, $code, $link)
    {
        Mail::queueTemplate('igniter.user::mail.password_reset_request', [
            'first_name' => $customer->first_name,
            'last_name' => $customer->last_name,
            'reset_code' => $code,
            'reset_link' => $link,
            'account_login_link' => page_url($this->loginPage),
        ], $customer);
    }
}
