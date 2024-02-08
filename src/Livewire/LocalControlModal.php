<?php

namespace Igniter\Orange\Livewire;

use DateTime;
use Exception;
use Igniter\Flame\Exception\ApplicationException;
use Igniter\Local\Models\Location;
use Igniter\System\Facades\Assets;
use Igniter\User\Facades\Auth;
use Igniter\Orange\Support\Url;
use Illuminate\Support\Collection;

class LocalControlModal extends \Livewire\Component
{
    public array $timeslotDates = [];

    public array $timeslotTimes = [];

    public string $orderType = '';

    public bool $isAsap = true;

    public string $orderDate = '';

    public string $orderTime = '';

    public string $defaultOrderType = Location::DELIVERY;

    public ?string $deliveryAddress = null;

    /**
     * @var \Igniter\Local\Classes\Location
     */
    protected $location;

    public function render()
    {
        return view('igniter-orange::livewire.local-control-modal', [
            'orderTypes' => $this->location->getOrderTypes(),
        ]);
    }

    public function mount()
    {
        Assets::addJs('igniter-orange::/js/local-control.js', 'local-control-js');

        $this->parseTimeslot($this->location->scheduleTimeslot());
        $this->updateCurrentOrderType();
        $this->updateNearbyAreaFromSavedAddress();

        $this->orderType = $this->location->orderType();
        $this->isAsap = $this->location->orderTimeIsAsap();
        $this->orderDate = $this->location->orderDateTime()?->format('Y-m-d');
        $this->orderTime = $this->location->orderDateTime()?->format('H:i');
        $this->deliveryAddress = $this->getDeliveryAddress()?->formatted_address;
    }

    public function boot()
    {
        $this->location = resolve('location');
    }

    public function onConfirm()
    {
        $this->validate([
            'orderType' => ['required', 'string'],
            'isAsap' => ['required', 'boolean'],
            'orderDate' => ['required_if:isAsap,0'],
            'orderTime' => ['required_if:isAsap,0'],
        ]);

        throw_unless($this->location->current(), new ApplicationException(
            lang('igniter.local::default.alert_location_required')
        ));

        throw_unless($orderType = $this->location->getOrderType($this->orderType), new ApplicationException(
            lang('igniter.local::default.alert_order_type_required')
        ));

        throw_if($orderType->isDisabled(), new ApplicationException($orderType->getDisabledDescription()));

        $timeSlotDateTime = $this->isAsap ? now() : make_carbon($this->orderDate.' '.$this->orderTime);
        throw_unless($this->location->checkOrderTime($timeSlotDateTime), new ApplicationException(
            sprintf(lang('igniter.local::default.alert_order_is_unavailable'), $this->location->getOrderType()->getLabel())
        ));

        $this->location->updateOrderType($orderType->getCode());

        $this->location->updateScheduleTimeSlot($timeSlotDateTime, $this->isAsap);

        return $this->redirect(Url::current(), navigate: true);
    }

    protected function getDeliveryAddress()
    {
        return optional(Auth::customer())->address
            ?? Auth::customer()?->addresses?->first();
    }

    protected function parseTimeslot(Collection $timeslot)
    {
        $timeslot->collapse()->each(function (DateTime $slot) {
            $dateKey = $slot->format('Y-m-d');
            $hourKey = $slot->format('H:i');
            $dateValue = make_carbon($slot)->isoFormat(lang('system::lang.moment.day_format'));
            $hourValue = make_carbon($slot)->isoFormat(lang('system::lang.moment.time_format'));

            $this->timeslotDates[$dateKey] = $dateValue;
            $this->timeslotTimes[$dateKey][$hourKey] = $hourValue;
        });
    }

    protected function updateCurrentOrderType()
    {
        if (!$this->location->current()) {
            return;
        }

        $sessionOrderType = $this->location->getSession('orderType');
        if ($sessionOrderType && $this->location->hasOrderType($sessionOrderType)) {
            return;
        }

        $orderType = $this->defaultOrderType;
        if (!$this->location->hasOrderType($orderType)) {
            $orderType = optional($this->location->getOrderTypes()->first(function ($orderType) {
                return !$orderType->isDisabled();
            }))->getCode();
        }

        if ($orderType) {
            $this->location->updateOrderType($orderType);
        }
    }

    protected function updateNearbyAreaFromSavedAddress()
    {
        if (!$address = $this->getDeliveryAddress()) {
            return;
        }

        $searchQuery = format_address($address->toArray(), false);
        if ($searchQuery == \Igniter\Local\Facades\Location::getSession('searchQuery')) {
            return;
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
        } catch (Exception) {
        }
    }
}
