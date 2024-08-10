<?php

namespace Igniter\Orange\Livewire;

use DateTime;
use Igniter\Local\Models\Location;
use Igniter\Main\Traits\ConfigurableComponent;
use Igniter\Orange\Livewire\Concerns\SearchesNearby;
use Igniter\System\Facades\Assets;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Session;
use Livewire\Livewire;

class FulfillmentModal extends \Livewire\Component
{
    use ConfigurableComponent;
    use SearchesNearby;

    public array $timeslotDates = [];

    public array $timeslotTimes = [];

    public string $orderType = '';

    public bool $isAsap = true;

    public string $orderDate = '';

    public string $orderTime = '';

    public string $defaultOrderType = Location::DELIVERY;

    public bool $showAddressPicker = false;

    public ?bool $hideDeliveryAddress = null;

    #[Session]
    public ?string $newSearchQuery = null;

    /**
     * @var \Igniter\Local\Classes\Location
     */
    protected $location;

    public static function componentMeta(): array
    {
        return [
            'code' => 'igniter-orange::fulfillment-modal',
            'name' => 'igniter.orange::default.component_fulfillment_modal_title',
            'description' => 'igniter.orange::default.component_fulfillment_modal_desc',
        ];
    }

    public function defineProperties()
    {
        return array_merge([
            'defaultOrderType' => [
                'label' => 'The default selected order type.',
                'type' => 'select',
                'options' => [Location::class, 'getOrderTypeOptions'],
            ],
        ], $this->definePropertiesSearchNearby());
    }

    public function render()
    {
        return view('igniter-orange::livewire.fulfillment-modal', [
            'orderTypes' => $this->location->getActiveOrderTypes(),
        ]);
    }

    public function mount()
    {
        Assets::addJs('igniter-orange::/js/fulfillment.js', 'fulfillment-js');

        $this->parseTimeslot($this->location->scheduleTimeslot());
        $this->updateCurrentOrderType();

        $this->orderType = $this->location->orderType();
        $this->isAsap = $this->location->orderTimeIsAsap();
        $this->orderDate = $this->location->orderDateTime()?->format('Y-m-d');
        $this->orderTime = $this->location->orderDateTime()?->format('H:i');
        $this->hideDeliveryAddress = !$this->location->orderTypeIsDelivery();
    }

    public function boot()
    {
        $this->location = resolve('location');
    }

    public function updating($name, $value)
    {
        throw_unless($this->location->current(), ValidationException::withMessages([
            'orderType' => lang('igniter.local::default.alert_location_required'),
        ]));

        if ($name == 'orderType') {
            $this->orderType = $value;
            $this->updateOrderType();
            $this->mount();
        }
    }

    public function onConfirm()
    {
        $this->validate([
            'orderType' => ['required', 'string'],
            'isAsap' => ['required', 'boolean'],
            'orderDate' => ['required_if:isAsap,0'],
            'orderTime' => ['required_if:isAsap,0'],
            'searchQuery' => ['required_if:showAddressPicker,1'],
        ]);

        throw_unless($this->location->current(), ValidationException::withMessages([
            'orderType' => lang('igniter.local::default.alert_location_required'),
        ]));

        $this->updateOrderType();

        $this->updateTimeslot();

        if ($this->searchQuery && $this->showAddressPicker) {
            $userLocation = $this->geocodeSearchQuery($this->searchQuery);
            if ($area = $this->location->current()->searchDeliveryArea($userLocation->getCoordinates())) {
                $this->location->updateUserPosition($userLocation);
                $this->location->updateNearbyArea($area);
                $this->location->putSession('searchQuery', $this->searchQuery);
            } else {
                throw ValidationException::withMessages([
                    'searchQuery' => lang('igniter.local::default.alert_delivery_area_unavailable'),
                ]);
            }
        }

        $this->showAddressPicker = false;

        return $this->redirect(Livewire::originalUrl(), navigate: true);
    }

    protected function parseTimeslot(Collection $timeslot)
    {
        $this->timeslotDates = [];
        $this->timeslotTimes = [];

        $timeslot->collapse()->each(function(DateTime $slot) {
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
            $orderType = optional($this->location->getOrderTypes()->first(function($orderType) {
                return !$orderType->isDisabled();
            }))->getCode();
        }

        if ($orderType) {
            $this->location->updateOrderType($orderType);
        }
    }

    protected function updateOrderType(): void
    {
        throw_unless($orderType = $this->location->getOrderType($this->orderType), ValidationException::withMessages([
            'orderType' => lang('igniter.local::default.alert_order_type_required'),
        ]));

        throw_if($orderType->isDisabled(), ValidationException::withMessages([
            'orderType' => $orderType->getDisabledDescription(),
        ]));

        $this->location->updateOrderType($orderType->getCode());
    }

    protected function updateTimeslot(): void
    {
        $timeSlotDateTime = $this->isAsap ? now() : make_carbon($this->orderDate.' '.$this->orderTime);
        throw_unless($this->location->checkOrderTime($timeSlotDateTime), ValidationException::withMessages([
            'isAsap' => sprintf(lang('igniter.local::default.alert_order_is_unavailable'), $this->location->getOrderType()->getLabel()),
        ]));

        $this->location->updateScheduleTimeSlot($timeSlotDateTime, $this->isAsap);
    }
}
