<?php

namespace Igniter\Orange\Livewire\Forms;

use Livewire\Attributes\Rule;
use Livewire\Form;

class RegisterForm extends Form
{
    #[Rule('required|between:1,48', as: 'igniter.user::default.settings.label_first_name')]
    public string $first_name;

    #[Rule('required|between:1,48', as: 'igniter.user::default.settings.label_last_name')]
    public string $last_name;

    #[Rule('required|email:filter|max:96|unique:customers,email', as: 'igniter.user::default.settings.label_email')]
    public string $email;

    #[Rule('required|min:6|max:32|confirmed', as: 'igniter.user::default.login.label_password')]
    public string $password;

    #[Rule('required', as: 'igniter.user::default.login.label_password_confirm')]
    public string $password_confirmation;

    #[Rule('required', as: 'igniter.user::default.settings.label_telephone')]
    public string $telephone;

    #[Rule('boolean', as: 'igniter.user::default.login.label_subscribe')]
    public string $newsletter;

    #[Rule('sometimes|boolean', as: 'igniter.user::default.login.label_i_agree')]
    public string $terms;

    public bool $status = true;
}
