<?php

namespace Igniter\Orange\Livewire\Forms;

use Igniter\User\Models\Customer;
use Livewire\Attributes\Rule;
use Livewire\Form;

class SettingsForm extends Form
{
    #[Rule('required|between:1,48', as: 'igniter.user::default.settings.label_first_name')]
    public string $first_name;

    #[Rule('required|between:1,48', as: 'igniter.user::default.settings.label_last_name')]
    public string $last_name;

    public string $telephone;

    #[Rule('required|email:filter|max:96|unique:customers,email', as: 'igniter.user::default.settings.label_email')]
    public string $email;

    #[Rule('boolean', as: 'igniter.user::default.settings.label_newletter')]
    public bool $newsletter;

    #[Rule('sometimes|min:6|max:32|current_password', as: 'igniter.user::default.login.label_old_password')]
    public string $old_password;

    #[Rule('required_with:old_password|min:6|max:32|confirmed', as: 'igniter.user::default.login.label_password')]
    public string $password;

    #[Rule('string', as: 'igniter.user::default.login.label_password_confirm')]
    public string $password_confirmation;

    public function fill(?Customer $customer)
    {
        $this->first_name = $customer->first_name ?? '';
        $this->last_name = $customer->last_name ?? '';
        $this->telephone = $customer->telephone ?? '';
        $this->email = $customer->email ?? '';
    }
}
