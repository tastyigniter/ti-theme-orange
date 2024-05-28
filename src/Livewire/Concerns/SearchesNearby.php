<?php

namespace Igniter\Orange\Livewire\Concerns;

use Exception;
use Igniter\Flame\Geolite\Facades\Geocoder;
use Igniter\Flame\Geolite\Model\Location as GeoliteLocation;
use Igniter\Local\Facades\Location;
use Igniter\Main\Traits\UsesPage;
use Igniter\User\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Session;
use Livewire\Livewire;

trait SearchesNearby
{
    use UsesPage;

    public ?string $searchQuery = null;

    public ?array $searchPoint = null;

    public string $menusPage = 'local.menus';

    public ?string $deliveryAddress = null;

    #[Session]
    public ?int $savedAddressId = null;

    protected string $searchField = 'searchQuery';

    public function definePropertiesSearchNearby()
    {
        return [
            'menusPage' => [
                'label' => 'Page to redirect to when a location is found',
                'type' => 'select',
                'options' => [static::class, 'getThemePageOptions'],
                'validationRule' => 'required|regex:/^[a-z0-9\-_\.]+$/i',
            ],
        ];
    }

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
            $userLocation = $this->geocodeUserPosition();

            Location::updateUserPosition($userLocation);
            Location::putSession('searchQuery', $this->searchQuery);

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

        $userLocation = $this->geocodeSearchQuery($searchQuery);

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

    #[On('userPositionUpdated')]
    public function onUserPositionUpdated($position = null)
    {
        $this->searchPoint = $position;

        try {
            $this->geocodeUserPosition();
        } catch (Exception $ex) {
            throw ValidationException::withMessages([$this->searchField => $ex->getMessage()]);
        }
    }

    public function onUpdateSearchQuery()
    {
        try {
            $userLocation = $this->geocodeUserPosition();

            Location::updateUserPosition($userLocation);
            Location::putSession('searchQuery', $this->searchQuery);
        } catch (Exception $ex) {
            throw ValidationException::withMessages([$this->searchField => $ex->getMessage()]);
        }

        return $this->redirect(Livewire::originalUrl(), navigate: true);
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
    protected function geocodeSearchQuery($searchQuery)
    {
        return $this->handleGeocodeResponse(Geocoder::geocode($searchQuery));
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

        $this->searchQuery = $userLocation->format();

        return $userLocation;
    }

    protected function handleGeocodeResponse($collection)
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

        return $userLocation;
    }

    protected function findNearByLocation(GeoliteLocation $userLocation)
    {
        $nearByLocation = Location::searchByCoordinates(
            $userLocation->getCoordinates()
        )->first(function($location) use ($userLocation) {
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

    protected function geocodeUserPosition(): mixed
    {
        throw_unless($searchQuery = $this->getSearchQuery(), ValidationException::withMessages([
            $this->searchField => lang('igniter.local::default.alert_no_search_query'),
        ]));

        return is_array($searchQuery)
            ? $this->geocodeSearchPoint($searchQuery)
            : $this->geocodeSearchQuery($searchQuery);
    }
}
