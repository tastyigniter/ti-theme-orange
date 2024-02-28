<?php

namespace Igniter\Orange\View\Components;

use Igniter\Local\Facades\Location;
use Igniter\Local\Models\ReviewSettings;
use Igniter\Orange\Data\LocationData;
use Igniter\System\Facades\Assets;
use Illuminate\View\Component;

class LocalHeader extends Component
{
    public function __construct(
        public bool $showThumb = true,
        public int $localThumbWidth = 80,
        public int $localThumbHeight = 80,
    )
    {
        Location::current()->loadCount([
            'reviews' => fn($q) => $q->isApproved(),
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
}
