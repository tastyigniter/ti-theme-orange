<?php

namespace Igniter\Orange\Livewire;

use Igniter\Local\Facades\Location;
use Igniter\Orange\Livewire\Concerns\SearchesNearby;
use Livewire\Component;

class LocalSearch extends Component
{
    use SearchesNearby;

    public function render()
    {
        return view('igniter-orange::livewire.local-search');
    }

    public function showDeliveryCoverageAlert()
    {
        if (!Location::orderTypeIsDelivery()) {
            return false;
        }

        if (!Location::requiresUserPosition()) {
            return false;
        }

        return Location::userPosition()->hasCoordinates()
            && !Location::checkDeliveryCoverage();
    }
}
