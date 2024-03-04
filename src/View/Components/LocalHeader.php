<?php

namespace Igniter\Orange\View\Components;

use Igniter\Local\Facades\Location;
use Igniter\Local\Models\ReviewSettings;
use Igniter\Orange\Data\LocationData;
use Igniter\Orange\Livewire\Concerns\WithReviews;
use Igniter\System\Facades\Assets;
use Illuminate\View\Component;

class LocalHeader extends Component
{
    use WithReviews;

    public function __construct(
        public bool $showThumb = true,
        public int $localThumbWidth = 320,
        public int $localThumbHeight = 160,
    ) {
        Location::current()->loadCount([
            'reviews' => fn ($q) => $q->isApproved(),
        ]);
    }

    public function shouldRender()
    {
        return !is_null(resolve('location')->current());
    }

    public function render()
    {
        Assets::addCss('igniter.local::/css/starrating.css', 'starrating-css');
        Assets::addJs('igniter.local::/js/starrating.js', 'starrating-js');

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
