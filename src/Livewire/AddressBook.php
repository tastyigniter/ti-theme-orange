<?php

namespace Igniter\Orange\Livewire;

use Igniter\Flame\Exception\ApplicationException;
use Igniter\System\Models\Country;
use Igniter\User\Facades\Auth;
use Igniter\Orange\Livewire\Forms\AddressBookForm;
use Livewire\WithPagination;

class AddressBook extends \Livewire\Component
{
    use WithPagination;

    public ?string $addressId = null;

    public ?int $defaultAddressId;

    public AddressBookForm $form;

    public int $itemsPerPage = 20;

    public string $sortOrder = 'created_at desc';

    public function render()
    {
        if ($address = $this->getAddress($this->addressId)) {
            $this->form->fill($address);
        }

        return view('igniter-orange::livewire.address-book', [
            'address' => $address,
            'addresses' => $this->loadAddressBook(),
        ]);
    }

    public function mount()
    {
        $this->defaultAddressId = Auth::customer()?->address?->getKey();
        $this->form->country_id = Country::getDefaultKey();
    }

    public function onSave()
    {
        $this->form->validate();

        throw_unless($customer = Auth::customer(),
            new ApplicationException('You must be logged in to manage your address book')
        );

        if ($this->addressId) {
            $address = $this->getAddress($this->addressId);
            $address->fill($this->form->except('address_id'));
            $address->save();
        } else {
            $customer->addresses()->create($this->form->except('address_id'));
        }

        flash()->success(lang('igniter.user::default.account.alert_updated_success'))->now();

        $this->addressId = null;
    }

    public function onSetDefault(string $addressId)
    {
        $customer = Auth::customer();
        throw_unless($customer?->addresses()->find($addressId),
            new ApplicationException('Address not found')
        );

        $customer->address_id = $this->defaultAddressId = $addressId;
        $customer->save();
    }

    public function onDelete(string $addressId)
    {
        $customer = Auth::customer();
        throw_unless($address = $customer?->addresses()->find($addressId),
            new ApplicationException('Address not found'));

        $address->customer_id = null;
        $address->save();

        flash()->success(lang('igniter.user::default.account.alert_deleted_success'))->now();

        $this->addressId = null;
    }

    protected function getAddress(?string $addressId)
    {
        return $addressId ? Auth::customer()?->addresses()?->find($addressId) : null;
    }

    protected function loadAddressBook()
    {
        if (!$customer = Auth::customer()) {
            return [];
        }

        return $customer->addresses()->listFrontEnd([
            'page' => $this->getPage(),
            'pageLimit' => $this->itemsPerPage,
            'sort' => $this->sortOrder,
        ]);
    }
}
