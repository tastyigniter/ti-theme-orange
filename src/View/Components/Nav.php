<?php

namespace Igniter\Orange\View\Components;

use Igniter\Pages\Classes\MenuManager;
use Igniter\Pages\Models\Menu;
use Illuminate\View\Component;

class Nav extends Component
{
    public array $menuItems = [];

    public string $activePage;

    public function __construct(public string $code)
    {
        $this->activePage = controller()->getPage()->getId();
    }

    public function render()
    {
        return view('igniter-orange::includes.navs.'.$this->code, [
            'menuItems' => $this->menuItems(),
        ]);
    }

    protected function menuItems()
    {
        $themeCode = controller()->getTheme()->getName();

        if ($menu = Menu::whereCode($this->code)->where('theme_code', $themeCode)->first()) {
            $this->menuItems = resolve(MenuManager::class)->generateReferences($menu, controller()->getLayout());
        }

        return $this->menuItems;
    }
}
