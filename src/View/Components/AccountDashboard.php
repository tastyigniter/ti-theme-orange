<?php

namespace Igniter\Orange\View\Components;

use Igniter\Cart\Facades\Cart;
use Igniter\User\Facades\Auth;
use Illuminate\View\Component;

class AccountDashboard extends Component
{
    public bool $hasDefaultAddress;

    public ?int $defaultAddressId;

    public string $formattedAddress;

    public function __construct(
        public string $customerName = '',
    )
    {
        $customer = Auth::getUser();
        $this->customerName = $customer?->full_name ?? '';
        $this->hasDefaultAddress = !is_null($customer?->address);
        $this->defaultAddressId = $customer?->address?->getKey();
        $this->formattedAddress = $this->hasDefaultAddress ? format_address($customer?->address) : '';
    }

    public function cartCount()
    {
        return Cart::count();
    }

    public function cartTotal()
    {
        return Cart::total();
    }

    public function render()
    {
        return view('igniter-orange::components.account-dashboard');
    }
}
