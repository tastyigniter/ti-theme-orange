<?php

namespace Igniter\Orange\View\Components;

use Igniter\Cart\Models\Menu;
use Igniter\Orange\Data\MenuItemData;
use Illuminate\View\Component;

class FeaturedItems extends Component
{
    public function __construct(
        public string $title = 'igniter.frontend::default.featured.text_featured_menus',
        public int $limit = 6,
        public int $itemsPerRow = 3,
        public int $itemWidth = 400,
        public int $itemHeight = 300,
        public bool $showThumb = true,
    ) {
    }

    public function render()
    {
        return view('igniter-orange::components.featured-items', [
            'items' => $this->loadItems(),
        ]);
    }

    protected function loadItems()
    {
        return Menu::query()->whereIsEnabled()->take($this->limit)->get()->mapInto(MenuItemData::class);
    }
}
