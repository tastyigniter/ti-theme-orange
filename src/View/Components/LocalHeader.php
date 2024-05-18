<?php

namespace Igniter\Orange\View\Components;

use Igniter\Local\Facades\Location;
use Igniter\Local\Models\ReviewSettings;
use Igniter\Main\Traits\ConfigurableComponent;
use Igniter\Main\Traits\UsesPage;
use Igniter\Orange\Data\LocationData;
use Igniter\Orange\Livewire\Concerns\WithReviews;
use Igniter\System\Facades\Assets;
use Illuminate\View\Component;

class LocalHeader extends Component
{
    use ConfigurableComponent;
    use UsesPage;
    use WithReviews;

    public function __construct(
        public bool $showThumb = true,
        public int $localThumbWidth = 320,
        public int $localThumbHeight = 160,
        public int $reviewPerPage = 10,
        public string $reviewSortOrder = 'created_at desc',
        public string $reviewsPage = 'local.reviews',
    ) {
        $this->itemPerPage = $this->reviewPerPage;
        $this->sortOrder = $this->reviewSortOrder;
    }

    public static function componentMeta(): array
    {
        return [
            'code' => 'igniter-orange::local-header',
            'name' => 'igniter.orange::default.component_local_header_title',
            'description' => 'igniter.orange::default.component_local_header_desc',
        ];
    }

    public function defineProperties(): array
    {
        return [
            'showThumb' => [
                'label' => 'Show location thumbnail',
                'type' => 'switch',
            ],
            'localThumbWidth' => [
                'label' => 'Thumbnail width',
                'type' => 'number',
            ],
            'localThumbHeight' => [
                'label' => 'Thumbnail height',
                'type' => 'number',
            ],
            'reviewPerPage' => [
                'label' => 'Number of reviews to display per page',
                'type' => 'number',
                'validationRule' => 'integer|min:1',
            ],
            'reviewSortOrder' => [
                'label' => 'Sort order',
                'type' => 'select',
                'options' => [static::class, 'getSortOrderOptionsWithReviews'],
                'validationRule' => 'required|string',
            ],
            'reviewsPage' => [
                'label' => 'Reviews page',
                'type' => 'select',
                'options' => [static::class, 'getThemePageOptions'],
                'validationRule' => 'required|regex:/^[a-z0-9\-_\.]+$/i',
            ],
        ];
    }

    public function shouldRender()
    {
        return !is_null(resolve('location')->current());
    }

    public function render()
    {
        Assets::addCss('igniter.local::/css/starrating.css', 'starrating-css');
        Assets::addJs('igniter.local::/js/starrating.js', 'starrating-js');

        Location::current()->loadCount([
            'reviews' => fn ($q) => $q->isApproved(),
        ]);

        return view('igniter-orange::components.local-header', [
            'locationInfo' => LocationData::current(),
            'allowReviews' => ReviewSettings::allowReviews(),
        ]);
    }

    public function listReviews()
    {
        return $this->loadReviewList(1);
    }
}
