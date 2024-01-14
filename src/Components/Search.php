<?php

namespace Igniter\Orange\Components;

use Exception;
use Igniter\Flame\Exception\ApplicationException;
use Igniter\Local\Facades\Location;
use Igniter\User\Facades\Auth;
use Igniter\User\Models\Address;
use Igniter\User\Models\Customer;

class Search extends \Igniter\System\Classes\BaseComponent
{
    use \Igniter\Local\Traits\SearchesNearby;
    use \Igniter\Main\Traits\UsesPage;

    protected $defaultAddress;

    protected $savedAddresses;

    public function defineProperties(): array
    {
        return [
            'hideSearch' => [
                'label' => 'lang:igniter.local::default.label_location_search_mode',
                'type' => 'switch',
                'comment' => 'lang:igniter.local::default.help_location_search_mode',
                'validationRule' => 'required|boolean',
            ],
            'menusPage' => [
                'label' => 'Menu Page',
                'type' => 'select',
                'default' => 'local'.DIRECTORY_SEPARATOR.'menus',
                'options' => [static::class, 'getThemePageOptions'],
                'validationRule' => 'required|regex:/^[a-z0-9\-_\/]+$/i',
            ],
        ];
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

    public function onRun()
    {
        $this->addJs('js/local.js', 'local-module-js');

        $this->prepareVars();
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

    protected function prepareVars()
    {
        $this->page['menusPage'] = $this->property('menusPage');
        $this->page['hideSearch'] = $this->property('hideSearch', false);
        $this->page['searchEventHandler'] = $this->getEventHandler('onSearchNearby');
        $this->page['pickerEventHandler'] = $this->getEventHandler('onSetSavedAddress');

        $this->page['searchQueryPosition'] = Location::userPosition();
        $this->page['searchDefaultAddress'] = $this->updateNearbyAreaFromSavedAddress(
            $this->getDefaultAddress()
        );
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
