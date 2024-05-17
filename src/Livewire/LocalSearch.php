<?php

namespace Igniter\Orange\Livewire;

use Igniter\Main\Traits\ConfigurableComponent;
use Igniter\Orange\Livewire\Concerns\SearchesNearby;
use Livewire\Component;

class LocalSearch extends Component
{
    use ConfigurableComponent;
    use SearchesNearby;

    public static function componentMeta(): array
    {
        return [
            'code' => 'igniter-orange::local-search',
            'name' => 'igniter.orange::default.component_local_search_title',
            'description' => 'igniter.orange::default.component_local_search_desc',
        ];
    }

    public function defineProperties()
    {
        return $this->definePropertiesSearchNearby();
    }

    public function render()
    {
        return view('igniter-orange::livewire.local-search');
    }
}
