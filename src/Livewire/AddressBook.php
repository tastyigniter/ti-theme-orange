<?php

namespace Igniter\Orange\Livewire;

use Igniter\Flame\Exception\ApplicationException;
use Igniter\Orange\Livewire\Forms\AddressBookForm;
use Igniter\System\Models\Country;
use Igniter\User\Facades\Auth;
use Livewire\WithPagination;

class AddressBook extends \Livewire\Component
{
    use WithPagination;

    public ?int $addressId = null;

    public ?int $defaultAddressId;

    public bool $showModal = false;

    public AddressBookForm $form;

    public int $itemsPerPage = 20;

    public string $sortOrder = 'created_at desc';

    public function render()
    {
        if ($address = $this->getAddress($this->addressId)) {
            $this->form->fillFrom($address, Auth::customer()->address_id);
        }

        return view('igniter-orange::livewire.address-book', [
            'selectAddress' => $address,
            'addresses' => $this->loadAddressBook(),
        ]);
    }

    public function mount()
    {
        $this->defaultAddressId = Auth::customer()?->address_id;
        $this->form->country_id = Country::getDefaultKey();
    }

    public function updated($property, $value)
    {
        if ($property === 'addressId') {
            $this->showModal = !empty($value);
            $this->form->reset();
            $this->resetErrorBag();
        }
    }

    public function onSave()
    {
        throw_unless($customer = Auth::customer(),
            new ApplicationException('You must be logged in to manage your address book')
        );

        $this->form->validate();

        if ($this->addressId) {
            $address = $this->getAddress($this->addressId);
            $address->fill($this->form->except('address_id'));
            $address->save();
        } else {
            $address = $customer->addresses()->create($this->form->except('address_id'));
        }

        if ($this->form->is_default) {
            $customer->address_id = $address->address_id;
            $customer->saveQuietly();
        }

        flash()->success(lang('igniter.user::default.account.alert_updated_success'))->now();

        $this->addressId = null;
        $this->showModal = false;
    }

    public function onSetDefault(string $addressId)
    {
        throw_unless($customer = Auth::customer(),
            new ApplicationException('You must be logged in to manage your address book')
        );

        $customer->saveDefaultAddress($addressId);

        $this->defaultAddressId = $addressId;
    }

    public function onDelete(string $addressId)
    {
        throw_unless($customer = Auth::customer(),
            new ApplicationException('You must be logged in to manage your address book')
        );

        $customer->deleteCustomerAddress($addressId);

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