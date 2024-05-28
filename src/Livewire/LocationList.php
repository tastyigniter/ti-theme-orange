<?php

namespace Igniter\Orange\Livewire;

use Igniter\Admin\Classes\FormField;
use Igniter\Admin\Widgets\Form;
use Igniter\Local\Facades\Location;
use Igniter\Local\Models\Location as LocationModel;
use Igniter\Local\Models\ReviewSettings;
use Igniter\Main\Traits\ConfigurableComponent;
use Igniter\Main\Traits\UsesPage;
use Igniter\Orange\Data\LocationData;
use Igniter\Orange\Livewire\Concerns\SearchesNearby;
use Igniter\User\Facades\AdminAuth;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Event;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Url;
use Livewire\WithPagination;

class LocationList extends \Livewire\Component
{
    use ConfigurableComponent;
    use SearchesNearby;
    use UsesPage;
    use WithPagination;

    /** Distance unit to use, mi or km */
    public string $distanceUnit = 'mi';

    public string $menusPage = 'local.menus';

    public int $itemPerPage = 20;

    public bool $showThumb = true;

    public int $thumbWidth = 95;

    public int $thumbHeight = 80;

    #[Url]
    public string $sortBy = 'distance';

    #[Url]
    public string $orderType = LocationModel::DELIVERY;

    #[Url]
    public string $search = '';

    public static function componentMeta(): array
    {
        return [
            'code' => 'igniter-orange::location-list',
            'name' => 'igniter.orange::default.component_location_list_title',
            'description' => 'igniter.orange::default.component_location_list_desc',
        ];
    }

    public function defineProperties(): array
    {
        return [
            'menusPage' => [
                'label' => 'igniter.orange::default.label_menus_page',
                'type' => 'select',
                'validationRule' => 'required|regex:/^[a-z0-9\-_\.]+$/i',
                'options' => [static::class, 'getThemePageOptions'],
            ],
            'itemPerPage' => [
                'label' => 'igniter.orange::default.label_items_per_page',
                'type' => 'number',
                'validationRule' => 'required|numeric|min:0',
            ],
            'showThumb' => [
                'label' => 'igniter.orange::default.label_show_thumb',
                'type' => 'switch',
                'validationRule' => 'required|boolean',
            ],
            'thumbWidth' => [
                'label' => 'igniter.orange::default.label_thumb_width',
                'type' => 'number',
                'validationRule' => 'required|numeric|min:0',
            ],
            'thumbHeight' => [
                'label' => 'igniter.orange::default.label_thumb_height',
                'type' => 'number',
                'validationRule' => 'required|numeric|min:0',
            ],
            'sortBy' => [
                'label' => 'igniter.orange::default.label_sort_by',
                'type' => 'select',
                'validationRule' => 'required|string',
            ],
            'orderType' => [
                'label' => 'igniter.orange::default.label_order_type',
                'type' => 'select',
                'validationRule' => 'required|string',
            ],
        ];
    }

    public static function getPropertyOptions(Form $form, FormField $field): array|Collection
    {
        return match ($field->getConfig('property')) {
            'sortBy' => collect((new static)->sorters())->mapWithKeys(function($sorter, $key) {
                return [$key => array_get($sorter, 'name')];
            })->all(),
            'orderType' => (new static)->orderTypes(),
            default => [],
        };
    }

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

        $eventResult = Event::dispatch('igniter.orange.extendLocationListSorting');
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
            'reviews' => fn($q) => $q->isApproved(),
        ])->with(['media', 'delivery_areas', 'settings', 'working_hours', 'reviews' => fn($q) => $q->isApproved()]);

        $filterByDeliveryAreas = $this->orderType == 'delivery';

        $results = $query->applyFilters($options)
            ->paginate($this->itemPerPage, $this->getPage());

        $coordinates = Location::userPosition()->getCoordinates();

        $collection = $results->getCollection()
            ->filter(fn($location) => $this->filterQueryResult($location, $coordinates, $filterByDeliveryAreas))
            ->map(fn($location) => new LocationData($location));

        return $results->setCollection($collection);
    }

    protected function filterQueryResult($location, $coordinates, $filterByDeliveryAreas = false)
    {
        return array_get($location->getSettings($this->orderType), 'is_enabled', 1) == 1;
    }
}
