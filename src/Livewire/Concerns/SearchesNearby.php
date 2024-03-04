<?php

namespace Igniter\Orange\Livewire\Concerns;

use Exception;
use Igniter\Flame\Exception\ApplicationException;
use Igniter\Flame\Geolite\Facades\Geocoder;
use Igniter\Flame\Geolite\Model\Location as GeoliteLocation;
use Igniter\Local\Facades\Location;
use Igniter\User\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Session;

trait SearchesNearby
{
    public ?string $searchQuery = null;

    public ?array $searchPoint = null;

    public string $menusPage = 'local'.DIRECTORY_SEPARATOR.'menus';

    public ?string $deliveryAddress = null;

    #[Session]
    public ?int $savedAddressId = null;

    protected string $searchField = 'searchQuery';

    public function mountSearchesNearby()
    {
        $this->searchQuery = Location::getSession('searchQuery');
        $this->deliveryAddress = Auth::customer()?->address?->formatted_address;
    }

    #[Computed]
    public function savedAddresses()
    {
        return collect(Auth::customer()?->addresses ?? []);
    }

    public function onSearchNearby()
    {
        try {
            if (!$searchQuery = $this->getSearchQuery()) {
                throw new ApplicationException(lang('igniter.local::default.alert_no_search_query'));
            }

            $userLocation = is_array($searchQuery)
                ? $this->geocodeSearchPoint($searchQuery)
                : $this->geocodeSearchQuery($searchQuery);

            $nearByLocation = $this->findNearByLocation($userLocation);

            request()->route()->setParameter('location', $nearByLocation->permalink_slug);

            return $this->redirect(restaurant_url($this->menusPage));
        } catch (Exception $ex) {
            throw ValidationException::withMessages([$this->searchField => $ex->getMessage()]);
        }
    }

    public function onSelectAddress($id)
    {
        $this->searchField = 'savedAddress';

        throw_unless($address = $this->savedAddresses()->firstWhere('address_id', $id), ValidationException::withMessages([
            $this->searchField => lang('igniter.local::default.alert_address_not_found'),
        ]));

        $searchQuery = format_address($address->toArray(), false);

        $userLocation = $this->geocodeSearchQuery($searchQuery, false);

        $this->searchQuery = null;

        if (!isset($this->location)) {
            $nearByLocation = $this->findNearByLocation($userLocation);

            request()->route()->setParameter('location', $nearByLocation->permalink_slug);

            return $this->redirect(restaurant_url($this->menusPage));
        }

        if ($area = $this->location->current()->searchDeliveryArea($userLocation->getCoordinates())) {
            $this->location->updateUserPosition($userLocation);
            $this->location->updateNearbyArea($area);
            $this->location->putSession('searchQuery', $searchQuery);
        } else {
            throw ValidationException::withMessages([
                $this->searchField => lang('igniter.local::default.alert_delivery_area_unavailable'),
            ]);
        }

        $this->searchField = 'searchQuery';
    }

    protected function getSearchQuery()
    {
        if ($coordinates = $this->searchPoint) {
            return $coordinates;
        }

        return $this->searchQuery;
    }

    /**
     * @return GeoliteLocation
     * @throws \Igniter\Flame\Exception\ApplicationException
     */
    protected function geocodeSearchQuery($searchQuery, bool $store = true)
    {
        $collection = Geocoder::geocode($searchQuery);

        $userLocation = $this->handleGeocodeResponse($collection, $store);

        if ($store) {
            Location::putSession('searchQuery', $searchQuery);
        }

        return $userLocation;
    }

    protected function geocodeSearchPoint($searchPoint)
    {
        throw_if(count($searchPoint) !== 2, ValidationException::withMessages([
            $this->searchField => lang('igniter.local::default.alert_no_search_query'),
        ]));

        [$latitude, $longitude] = $searchPoint;
        throw_if(!strlen($latitude) || !strlen($longitude), ValidationException::withMessages([
            $this->searchField => lang('igniter.local::default.alert_no_search_query'),
        ]));

        $collection = Geocoder::reverse($latitude, $longitude);

        $userLocation = $this->handleGeocodeResponse($collection);

        Location::putSession('searchPoint', $searchPoint);
        Location::putSession('searchQuery', $userLocation->format());

        return $userLocation;
    }

    protected function handleGeocodeResponse($collection, bool $store = true)
    {
        if (!$collection || $collection->isEmpty()) {
            Log::error(implode(PHP_EOL, Geocoder::getLogs()));

            throw ValidationException::withMessages([
                $this->searchField => lang('igniter.local::default.alert_invalid_search_query'),
            ]);
        }

        $userLocation = $collection->first();
        if (!$userLocation->hasCoordinates()) {
            throw ValidationException::withMessages([
                $this->searchField => lang('igniter.local::default.alert_invalid_search_query'),
            ]);
        }

        if ($store) {
            Location::updateUserPosition($userLocation);
        }

        return $userLocation;
    }

    protected function findNearByLocation(GeoliteLocation $userLocation)
    {
        $nearByLocation = Location::searchByCoordinates(
            $userLocation->getCoordinates()
        )->first(function ($location) use ($userLocation) {
            if ($area = $location->searchDeliveryArea($userLocation->getCoordinates())) {
                Location::updateNearbyArea($area);

                return $area;
            }
        });

        throw_unless($nearByLocation, ValidationException::withMessages([
            $this->searchField => lang('igniter.local::default.alert_no_found_restaurant'),
        ]));

        return $nearByLocation;
    }
}
