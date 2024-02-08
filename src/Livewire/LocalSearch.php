<?php

namespace Igniter\Orange\Livewire;

use Exception;
use Igniter\Flame\Exception\ApplicationException;
use Igniter\Local\Facades\Location;
use Igniter\Local\Traits\SearchesNearby;
use Igniter\System\Traits\AssetMaker;
use Igniter\User\Facades\Auth;
use Igniter\User\Models\Address;
use Igniter\User\Models\Customer;
use Livewire\Component;

class LocalSearch extends Component
{
    use AssetMaker;
    use SearchesNearby;

    public ?string $searchQuery = null;

    public function render()
    {
        return view('igniter-orange::livewire.local-search');
    }

    public function mount()
    {
    }

    public function onSetSavedAddress()
    {
        if (!$customer = Auth::customer()) {
            return null;
        }

        if (!is_numeric($addressId = post('addressId'))) {
            throw new ApplicationException(lang('igniter.local::default.alert_address_id_required'));
        }

        if (!$address = $customer->addresses()->find($addressId)) {
            throw new ApplicationException(lang('igniter.local::default.alert_address_not_found'));
        }

        Customer::withoutEvents(function () use ($customer, $address) {
            $customer->address_id = $address->address_id;
            $customer->save();
        });

        $customer->reload();
        $this->controller->pageCycle();

        $this->prepareVars();

        return redirect()->back();
    }

    public function showAddressPicker()
    {
        return Auth::customer() && $this->getDefaultAddress();
    }

    public function getSavedAddresses()
    {
        if (!is_null($this->savedAddresses)) {
            return $this->savedAddresses;
        }

        if (!$customer = Auth::customer()) {
            return null;
        }

        return $this->savedAddresses = $customer->addresses()->get();
    }

    public function showDeliveryCoverageAlert()
    {
        if (!Location::orderTypeIsDelivery()) {
            return false;
        }

        if (!Location::requiresUserPosition()) {
            return false;
        }

        return Location::userPosition()->hasCoordinates()
            && !Location::checkDeliveryCoverage();
    }

    protected function updateNearbyAreaFromSavedAddress($address)
    {
        if (!$address instanceof Address) {
            return $address;
        }

        $searchQuery = format_address($address->toArray(), false);
        if ($searchQuery == Location::getSession('searchQuery')) {
            return $address;
        }

        try {
            $userLocation = $this->geocodeSearchQuery($searchQuery);
            Location::searchByCoordinates($userLocation->getCoordinates())
                ->first(function ($location) use ($userLocation) {
                    if ($area = $location->searchDeliveryArea($userLocation->getCoordinates())) {
                        Location::updateNearbyArea($area);

                        return $area;
                    }
                });
        } catch (Exception $ex) {
        }

        return $address;
    }

    protected function getDefaultAddress()
    {
        if (!is_null($this->defaultAddress)) {
            return $this->defaultAddress;
        }

        return $this->defaultAddress = optional(Auth::customer())->address
            ?? optional($this->getSavedAddresses())->first();
    }
}
