<?php

namespace Igniter\Orange\Components;

use Igniter\Cart\Classes\OrderTypes;
use Igniter\Local\Classes\CoveredArea;
use Igniter\Local\Classes\CoveredAreaCondition;
use Igniter\Local\Facades\Location;
use Igniter\Local\Models\Location as LocationModel;
use Igniter\Local\Models\WorkingHour;

class Info extends \Igniter\System\Classes\BaseComponent
{
    public function defineProperties()
    {
        return [];
    }

    public function onRun()
    {
        $this->page['infoTimeFormat'] = lang('system::lang.moment.time_format');
        $this->page['openingTimeFormat'] = lang('system::lang.moment.day_time_format_short');
        $this->page['lastOrderTimeFormat'] = lang('system::lang.moment.day_time_format');

        $this->page['locationInfo'] = $this->makeInfoObject();
    }

    public function getAreaConditionLabels(CoveredArea $area)
    {
        return $area->listConditions()->map(function (CoveredAreaCondition $condition) {
            return ucfirst(strtolower($condition->getLabel()));
        })->all();
    }

    protected function mapIntoCoveredArea($locationCurrent)
    {
        return $locationCurrent->listDeliveryAreas()->mapInto(CoveredArea::class);
    }

    protected function listWorkingHours($locationCurrent)
    {
        return $locationCurrent->getWorkingHours()->groupBy(function ($model) {
            return $model->day->isoFormat('dddd');
        });
    }

    protected function listScheduleItems($locationCurrent)
    {
        $scheduleTypes = collect(resolve(OrderTypes::class)->listOrderTypes())
            ->prepend(['name' => 'igniter.local::default.text_opening'], LocationModel::OPENING)
            ->all();

        $scheduleItems = [];
        foreach ($scheduleTypes as $code => $definition) {
            $schedule = $locationCurrent->createScheduleItem($code);
            foreach (WorkingHour::make()->getWeekDaysOptions() as $index => $day) {
                $hours = array_map(function ($hour) {
                    $hour['open'] = now()->setTimeFromTimeString($hour['open'])->isoFormat(lang('system::lang.moment.time_format'));
                    $hour['close'] = now()->setTimeFromTimeString($hour['close'])->isoFormat(lang('system::lang.moment.time_format'));

                    return $hour;
                }, array_get($schedule->getHours(), $index, []));

                $scheduleItems[$code][$day] = array_filter($hours, function ($hour) {
                    return (bool)$hour['status'];
                });
            }
        }

        return [$scheduleTypes, $scheduleItems];
    }

    protected function makeInfoObject()
    {
        $object = new \stdClass();

        $current = Location::current();

        $object->name = $current->getName();
        $object->description = $current->getDescription();

        $object->orderType = Location::getOrderType();
        $object->orderTypes = Location::getOrderTypes();

        $object->opensAllDay = $current->workingHourType('opening') == '24_7';
        $object->hasDelivery = $current->hasDelivery();
        $object->hasCollection = $current->hasCollection();
        $object->deliveryMinutes = $current->deliveryMinutes();
        $object->collectionMinutes = $current->collectionMinutes();
        $object->openingSchedule = Location::openingSchedule();
        $object->deliverySchedule = Location::deliverySchedule();
        $object->collectionSchedule = Location::collectionSchedule();
        $object->lastOrderTime = Location::lastOrderTime();

        $object->payments = $current->listAvailablePayments()->pluck('name')->all();
        $object->schedules = $this->listWorkingHours($current);
        $object->deliveryAreas = $this->mapIntoCoveredArea($current);

        [$object->scheduleTypes, $object->scheduleItems] = $this->listScheduleItems($current);

        $object->model = $current;

        return $object;
    }
}
