<?php

namespace Igniter\Orange\View\Components;

use Igniter\Local\Facades\Location;
use Igniter\Main\Traits\ConfigurableComponent;
use Illuminate\View\Component;

class Fulfillment extends Component
{
    use ConfigurableComponent;

    public static function componentMeta(): array
    {
        return [
            'code' => 'igniter-orange::fulfillment',
            'name' => 'igniter.orange::default.component_fulfillment_title',
            'description' => 'igniter.orange::default.component_fulfillment_desc',
        ];
    }

    public function render()
    {
        return view('igniter-orange::components.fulfillment', [
            'isAsap' => Location::orderTimeIsAsap(),
            'activeOrderType' => Location::getOrderType(),
            'orderDateTime' => Location::orderDateTime(),
        ]);
    }
}
