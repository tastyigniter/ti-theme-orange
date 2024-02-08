<?php

namespace Igniter\Orange\Livewire;

use Igniter\Cart\Facades\Cart;
use Igniter\Flame\Exception\ApplicationException;
use Igniter\User\Facades\Auth;
use Igniter\Orange\Livewire\Forms\SettingsForm;
use Livewire\Component;

class AccountSettings extends Component
{
    public SettingsForm $form;

    public function render()
    {
        return view('igniter-orange::livewire.account-settings');
    }

    public function mount()
    {
        $this->form->fill(Auth::customer());
    }

    public function cartCount()
    {
        return Cart::count();
    }

    public function cartTotal()
    {
        return Cart::total();
    }

    public function onUpdate()
    {
        throw_unless($customer = Auth::customer(),
            new ApplicationException('You must be logged in to manage your address book')
        );

        $this->form->validate();

        $customer->fill($this->form->except(['old_password', 'password_confirmation']));
        $customer->save();

        if ($this->form->old_password) {
            Auth::logout();

            session()->invalidate();
            session()->regenerateToken();

            return redirect()->back();
        }

        flash()->success(lang('igniter.user::default.settings.alert_updated_success'));
    }
}
