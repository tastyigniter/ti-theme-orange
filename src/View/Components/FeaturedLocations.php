<?php

declare(strict_types=1);

namespace Igniter\Orange\View\Components;

use Igniter\Local\Classes\FeaturedLocations as FeaturedLocationIds;
use Igniter\Local\Models\Location as LocationModel;
use Igniter\Main\Traits\ConfigurableComponent;
use Igniter\Main\Traits\UsesPage;
use Igniter\Orange\Data\LocationData;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;
use Override;

final class FeaturedLocations extends Component
{
    use ConfigurableComponent;
    use UsesPage;

    public function __construct(
        public string $title = 'igniter.orange::default.text_featured_locations',
        public int $limit = 6,
        public int $itemsPerRow = 3,
        public bool $showThumb = true,
        public string $menusPage = 'local.menus',
    ) {}

    public static function componentMeta(): array
    {
        return [
            'code' => 'igniter-orange::featured-locations',
            'name' => 'igniter.orange::default.component_featured_locations_title',
            'description' => 'igniter.orange::default.component_featured_locations_desc',
        ];
    }

    public function defineProperties(): array
    {
        return [
            'title' => [
                'label' => 'Title',
                'type' => 'text',
                'validationRule' => 'string',
            ],
            'limit' => [
                'label' => 'lang:igniter.frontend::default.featured.label_limit',
                'span' => 'left',
                'type' => 'number',
                'validationRule' => 'required|integer|min:1',
            ],
            'itemsPerRow' => [
                'label' => 'lang:igniter.frontend::default.featured.label_items_per_row',
                'span' => 'right',
                'type' => 'select',
                'options' => [1 => 'One', 2 => 'Two', 3 => 'Three', 4 => 'Four'],
                'validationRule' => 'required|integer',
            ],
            'showThumb' => [
                'label' => 'Show thumbnail image',
                'type' => 'switch',
                'validationRule' => 'required|boolean',
            ],
            'menusPage' => [
                'label' => 'igniter.orange::default.label_menus_page',
                'type' => 'select',
                'options' => self::getThemePageOptions(...),
                'validationRule' => 'required|regex:/^[a-z0-9\-_\.]+$/i',
            ],
        ];
    }

    #[Override]
    public function render(): View
    {
        return view('igniter-orange::components.featured-locations', [
            'featuredLocations' => $this->loadLocations(),
        ]);
    }

    /**
     * @return Collection<int, LocationData>
     */
    public function loadLocations(): Collection
    {
        $ids = resolve(FeaturedLocationIds::class)->ids();
        if ($ids === []) {
            return collect();
        }

        return LocationModel::query()
            ->whereIsEnabled()
            ->whereIn('location_id', $ids)
            ->get()
            ->shuffle()
            ->take(max(1, $this->limit))
            ->map(fn(LocationModel $location): LocationData => new LocationData($location))
            ->values();
    }
}
