<?php

namespace Igniter\Orange\Components;

use Igniter\Local\Facades\Location;
use Igniter\Local\Models\Location as LocationModel;
use Igniter\Local\Traits\SearchesNearby;
use Igniter\User\Facades\AdminAuth;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Event;

class LocalList extends \Igniter\System\Classes\BaseComponent
{
    use SearchesNearby;

    protected static $registeredSorting;

    public function defineProperties(): array
    {
        return [
            'distanceUnit' => [
                'label' => 'Distance unit to use, mi or km',
                'type' => 'text',
                'default' => 'mi',
                'validationRule' => 'required|in:km,mi',
            ],
            'searchParamName' => [
                'type' => 'text',
                'default' => 'search',
            ],
            'sortByParamName' => [
                'type' => 'text',
                'default' => 'sort_by',
            ],
            'orderTypeParamName' => [
                'type' => 'text',
                'default' => 'order_type',
            ],
        ];
    }

    public function onRun()
    {
        $this->addJs('js/local.js', 'local-js');

        $this->page['distanceUnit'] = $this->property('distanceUnit', setting('distance_unit'));
        $this->page['openingTimeFormat'] = lang('system::lang.moment.day_time_format_short');
        $this->page['searchTermParam'] = $this->property('searchParamName');
        $this->page['sortByParam'] = $this->property('sortByParamName');
        $this->page['orderTypeParam'] = $this->property('orderTypeParamName');

        $this->page['searchTerm'] = $this->page['filterSearch'] = $this->getSearchTerm();
        $this->page['activeSortBy'] = $this->page['filterSorted'] = $this->getSortBy();
        $this->page['listSorting'] = $this->page['filterSorters'] = $this->getSorting();
        $this->page['activeOrderType'] = $this->getOrderType();
        $this->page['listOrderTypes'] = $this->getOrderTypes();
        $this->page['filterPageUrl'] = $this->buildPageUrl();
        $this->page['userPosition'] = Location::userPosition();

        $this->page['locationsList'] = $this->loadList();
    }

    protected function loadList()
    {
        $sortBy = $this->getSortByCondition();

        $options = [
            'search' => $this->getSearchTerm(),
            'sort' => $sortBy,
        ];

        if (!optional(AdminAuth::getUser())->hasPermission('Admin.Locations')) {
            $options['enabled'] = true;
        }

        if ($coordinates = Location::userPosition()->getCoordinates()) {
            $options['position']['latitude'] = $coordinates->getLatitude();
            $options['position']['longitude'] = $coordinates->getLongitude();
        }

        $query = LocationModel::withCount([
            'reviews' => function ($q) {
                $q->isApproved();
            },
        ]);

        $searchDeliveryAreas = false;
        if (strlen($orderType = $this->getOrderType())) {
            if ($orderType == 'delivery') {
                $searchDeliveryAreas = true;
            }

            $query->whereHas('all_options', function ($q) use ($orderType) {
                $q->where('item', 'offer_'.$orderType)
                    ->where('value', '1')->orWhere('value', 1);
            });
        }

        $query->applyFilters($options);

        $page = $this->param('page', 1);
        $pageLimit = $this->param('pageLimit', $this->property('pageLimit', 20));

        $results = $query->get()->forPage($page, $pageLimit);

        $results = $this->mapIntoObjects(
            $this->filterQueryResult($results, $searchDeliveryAreas)
        );

        return new LengthAwarePaginator(
            $results,
            $query->toBase()->getCountForPagination(),
            $pageLimit,
            $page,
            [
                'path' => request()->url(),
                'query' => request()->query(),
            ]
        );
    }

    protected function getSorting()
    {
        $url = page_url().'?';
        if ($searchTerm = $this->getSearchTerm()) {
            $url .= $this->property('searchParamName').'='.$searchTerm.'&';
        }

        if ($orderType = $this->getOrderType()) {
            $url .= $this->property('orderTypeParamName').'='.$orderType.'&';
        }

        return collect($this->listSorting())
            ->sortBy('priority')
            ->mapWithKeys(function ($sorting, $code) use ($url) {
                $sorting['href'] = $url.$this->property('sortByParamName').'='.$code;

                return [$code => $sorting];
            })
            ->all();
    }

    protected function listSorting()
    {
        if (self::$registeredSorting) {
            return self::$registeredSorting;
        }

        $result = [
            'distance' => [
                'name' => lang('igniter.local::default.text_filter_distance'),
                'priority' => 0,
                'condition' => 'distance asc',
            ],
            'newest' => [
                'name' => lang('igniter.local::default.text_filter_newest'),
                'priority' => 1,
                'condition' => 'location_id desc',
            ],
            'rating' => [
                'name' => lang('igniter.local::default.text_filter_rating'),
                'priority' => 2,
                'condition' => 'reviews_count desc',
            ],
            'name' => [
                'name' => lang('admin::lang.label_name'),
                'priority' => 3,
                'condition' => 'location_name asc',
            ],
        ];

        $eventResult = Event::fire('local.list.extendSorting');
        if (is_array($eventResult)) {
            $result = array_merge($result, ...array_filter($eventResult));
        }

        return self::$registeredSorting = $result;
    }

    protected function getSortBy()
    {
        $sortByParamName = $this->property('sortByParamName');

        return input($sortByParamName, $this->param($sortByParamName));
    }

    protected function getSearchTerm()
    {
        $searchParamName = $this->property('searchParamName');

        return input($searchParamName, $this->param($searchParamName));
    }

    protected function getOrderType()
    {
        $orderTypeParamName = $this->property('orderTypeParamName');

        return input($orderTypeParamName, $this->param($orderTypeParamName));
    }

    protected function getOrderTypes()
    {
        return Location::current()->getOrderTypeOptions();
    }

    protected function mapIntoObjects($collection)
    {
        return $collection->map(function ($location) {
            return $this->createLocationObject($location);
        });
    }

    protected function createLocationObject($location)
    {
        $object = new \stdClass();

        $object->name = $location->location_name;
        $object->permalink = $location->permalink_slug;
        $object->address = $location->getAddress();
        $object->reviewsScore = $location->reviews_score();
        $object->reviewsCount = $location->reviews_count;
        $object->distance = $location->distance;

        $object->thumb = ($object->hasThumb = $location->hasMedia('thumb'))
            ? $location->getThumb()
            : null;

        $object->orderTypes = $location->availableOrderTypes();

        $object->openingSchedule = $location->newWorkingSchedule('opening');
        $object->deliverySchedule = $object->orderTypes->get(LocationModel::DELIVERY)->getSchedule();
        $object->collectionSchedule = $object->orderTypes->get(LocationModel::COLLECTION)->getSchedule();
        $object->hasDelivery = $location->hasDelivery();
        $object->hasCollection = $location->hasCollection();
        $object->deliveryMinutes = $location->deliveryMinutes();
        $object->collectionMinutes = $location->collectionMinutes();
        $object->openingTime = make_carbon($object->openingSchedule->getOpenTime());
        $object->deliveryTime = make_carbon($object->deliverySchedule->getOpenTime());
        $object->collectionTime = make_carbon($object->collectionSchedule->getOpenTime());

        $object->model = $location;

        return $object;
    }

    protected function getSortByCondition()
    {
        $sortBy = $this->getSortBy();
        if ($sortBy == 'distance' && !Location::userPosition()->isValid()) {
            flash()->warning('Could not determine user location')->now();

            return null;
        }

        return array_get($this->getSorting(), $sortBy.'.condition');
    }

    protected function filterQueryResult($collection, $searchDeliveryAreas = false)
    {
        $coordinates = Location::userPosition()->getCoordinates();
        if ($searchDeliveryAreas && $coordinates) {
            $collection = $collection->filter(function ($location) use ($coordinates) {
                return (bool)$location->searchDeliveryArea($coordinates);
            });
        }

        return $collection;
    }

    protected function buildPageUrl()
    {
        $query = array_except(request()->query(), [$this->property('orderTypeParamName')]);

        return page_url().'?'.http_build_query($query).'&';
    }
}
