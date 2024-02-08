<?php

namespace Igniter\Orange\Livewire;

use Igniter\User\Facades\Auth;
use Livewire\Attributes\Computed;

class AddressPickerModal extends \Livewire\Component
{
    /**
     * @var \Igniter\Local\Classes\Location
     */
    protected $location;

    public ?int $selectedId = null;

    public function render()
    {
        return view('igniter-orange::livewire.address-picker-modal');
    }

    public function mount()
    {
        $this->selectedId = Auth::customer()?->address?->getKey();
    }

    public function onConfirm()
    {
        $this->location = resolve('location');

    }

    #[Computed]
    public function savedAddresses()
    {
        return Auth::customer()?->addresses ?? [];
    }
}
