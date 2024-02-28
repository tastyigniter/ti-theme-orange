<?php

namespace Igniter\Orange\Livewire;

use Igniter\Local\Facades\Location;
use Igniter\Local\Models\Location as LocationModel;
use Igniter\Local\Models\ReviewSettings;
use Igniter\Orange\Data\LocationData;
use Igniter\User\Facades\AdminAuth;
use Illuminate\Support\Facades\Event;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Url;
use Livewire\WithPagination;

class LocationList extends \Livewire\Component
{
    use WithPagination;

    /** Distance unit to use, mi or km */
    public string $distanceUnit = 'mi';

    public string $menusPage = 'local'.DIRECTORY_SEPARATOR.'menus';

    public int $itemPerPage = 20;

    public string $sortOrder = 'menu_priority asc';

    #[Url]
    public string $sortBy = 'distance';

    #[Url]
    public string $orderType = LocationModel::DELIVERY;

    #[Url]
    public string $search = '';

    public function render()
    {
        return view('igniter-orange::livewire.location-list', [
            'allowReviews' => ReviewSettings::allowReviews(),
            'searchQueryPosition' => resolve('location')->userPosition(),
            'locationsList' => $this->loadList(),
        ]);
    }

    public function mount()
    {
        $this->distanceUnit = setting('distance_unit');
    }

    #[Computed, Locked]
    public function orderTypes()
    {
        return LocationModel::getOrderTypeOptions();
    }

    #[Computed, Locked]
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
            $options['position'] = [[
                'latitude' => $coordinates->getLatitude(),
                'longitude' => $coordinates->getLongitude(),
            ]];
        }

        $options['pageLimit'] = $this->itemPerPage;
        $options['search'] = $this->search;

        $options['sort'] = !$coordinates && $this->sortBy === 'distance'
            ? array_get($this->sorters, 'name.condition')
            : array_get($this->sorters, $this->sortBy.'.condition');

        $query = LocationModel::withCount([
            'reviews' => fn ($q) => $q->isApproved(),
        ])->with(['media', 'delivery_areas', 'settings', 'working_hours', 'reviews' => fn ($q) => $q->isApproved()]);

        $filterByDeliveryAreas = $this->orderType == 'delivery';

        $results = $query->applyFilters($options)
            ->paginate($this->itemPerPage, $this->getPage());

        $coordinates = Location::userPosition()->getCoordinates();

        $collection = $results->getCollection()
            ->filter(fn ($location) => $this->filterQueryResult($location, $coordinates, $filterByDeliveryAreas))
            ->map(fn ($location) => new LocationData($location));

        return $results->setCollection($collection);
    }

    protected function filterQueryResult($location, $coordinates, $filterByDeliveryAreas = false)
    {
        return array_get($location->getSettings($this->orderType), 'is_enabled', 1) == 1;
    }
}
