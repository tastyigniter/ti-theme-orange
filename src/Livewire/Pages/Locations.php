<?php

namespace Igniter\Orange\Livewire\Pages;

use Igniter\Local\Facades\Location;
use Igniter\Local\Models\Location as LocationModel;
use Igniter\Local\Traits\SearchesNearby;
use Igniter\User\Facades\AdminAuth;
use Igniter\Orange\Data\LocationData;
use Illuminate\Support\Facades\Event;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\WithPagination;

class Locations extends \Livewire\Component
{
    use SearchesNearby;
    use WithPagination;

    /** Distance unit to use, mi or km */
    public string $distanceUnit = 'mi';

    public int $itemPerPage = 20;

    public string $sortOrder = 'menu_priority asc';

    #[Url]
    public string $sortBy = 'distance';

    #[Url]
    public string $orderType = LocationModel::DELIVERY;

    #[Url]
    public string $search = '';

    public string $menusPage = 'local'.DIRECTORY_SEPARATOR.'menus';

    public function render()
    {
        return view('igniter-orange::livewire.pages.locations', [
            'searchQueryPosition' => resolve('location')->userPosition(),
            'locationsList' => $this->loadList(),
        ]);
    }

    public function mount()
    {
        $this->distanceUnit = setting('distance_unit');
    }

    #[Computed]
    public function orderTypes()
    {
        return LocationModel::getOrderTypeOptions();
    }

    #[Computed]
    public function sorters()
    {
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

        return $result;
    }

    protected function loadList()
    {
        if (!optional(AdminAuth::getUser())->hasPermission('Admin.Locations')) {
            $options['enabled'] = true;
        }

        if ($coordinates = Location::userPosition()->getCoordinates()) {
            $options['position']['latitude'] = $coordinates->getLatitude();
            $options['position']['longitude'] = $coordinates->getLongitude();
        }

        $options['pageLimit'] = $this->itemPerPage;
        $options['search'] = $this->search;

        $options['sort'] = !$coordinates && $this->sortBy === 'distance'
            ? array_get($this->sorters, 'name.condition')
            : array_get($this->sorters, $this->sortBy.'.condition');

        $query = LocationModel::withCount([
            'reviews' => fn($q) => $q->isApproved(),
        ]);

        $searchDeliveryAreas = false;
        if ($this->orderType == 'delivery') {
            $searchDeliveryAreas = true;
        }

        //            $query->whereHas('all_options', function ($q) {
        //                $q->where('item', 'offer_'.$this->orderType)
        //                    ->where('value', '1')->orWhere('value', 1);
        //            });

        $results = $query->applyFilters($options)
            ->paginate($this->itemPerPage, $this->getPage());

        $collection = $this->filterQueryResult($results->getCollection(), $searchDeliveryAreas)
            ->map(fn($location) => new LocationData($location));

        return $results->setCollection($collection);
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

    protected function buildPageUrl()
    {
        $query = array_except(request()->query(), [$this->property('orderTypeParamName')]);

        return page_url().'?'.http_build_query($query).'&';
    }
}
