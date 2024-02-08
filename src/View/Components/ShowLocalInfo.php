<?php

namespace Igniter\Orange\View\Components;

use Igniter\Orange\Data\LocationData;
use Illuminate\View\Component;

class ShowLocalInfo extends Component
{
    public function __construct(
        public bool $showThumb = true,
        public int $localThumbWidth = 80,
        public int $localThumbHeight = 80,
    )
    {
    }

    public function shouldRender()
    {
        return !is_null(resolve('location')->current());
    }

    public function render()
    {
        return view('igniter-orange::components.show-local-info', [
            'locationInfo' => LocationData::current(),
        ]);
    }
}
