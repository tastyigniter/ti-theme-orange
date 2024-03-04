<?php

namespace Igniter\Orange\Livewire;

use Igniter\Orange\Livewire\Concerns\SearchesNearby;
use Livewire\Component;

class LocalSearch extends Component
{
    use SearchesNearby;

    public function render()
    {
        return view('igniter-orange::livewire.local-search');
    }
}
