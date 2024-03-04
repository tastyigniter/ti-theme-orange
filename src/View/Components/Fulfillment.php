<?php

namespace Igniter\Orange\View\Components;

use Igniter\Local\Facades\Location;
use Illuminate\View\Component;

class Fulfillment extends Component
{
    public function render()
    {
        return view('igniter-orange::components.fulfillment', [
            'isAsap' => Location::orderTimeIsAsap(),
            'activeOrderType' => Location::getOrderType(),
            'orderDateTime' => Location::orderDateTime(),
        ]);
    }
}
