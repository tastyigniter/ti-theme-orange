<?php

namespace Igniter\Orange\Livewire\Forms;

use Livewire\Attributes\Rule;
use Livewire\Form;

class LoginForm extends Form
{
    #[Rule('required|email:filter|max:96', as: 'lang:igniter.user::default.settings.label_email')]
    public string $email;

    #[Rule('required|min:8|max:40', as: 'lang:igniter.user::default.login.label_password')]
    public string $password;

    #[Rule('nullable|boolean', as: 'lang:igniter.user::default.login.label_remember')]
    public bool $remember = true;
}
