<?php

namespace Igniter\Orange\View\Components;

use Igniter\Local\Facades\Location;
use Illuminate\View\Component;

class LocalControl extends Component
{
    public function render()
    {
        return view('igniter-orange::components.local-control', [
            'isAsap' => Location::orderTimeIsAsap(),
            'activeOrderType' => Location::getOrderType(),
            'orderDateTime' => Location::orderDateTime(),
        ]);
    }
}
