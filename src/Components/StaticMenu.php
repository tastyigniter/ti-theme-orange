<?php

namespace Igniter\Orange\Components;

use Igniter\Pages\Classes\MenuManager;
use Igniter\Pages\Models\Menu;
use Igniter\System\Classes\BaseComponent;

class StaticMenu extends BaseComponent
{
    /**
     * @var string The menu name.
     */
    public $menuName;

    /**
     * @var array
     */
    protected $menuItems;

    protected static $menuCache;

    public function defineProperties(): array
    {
        return [
            'code' => [
                'label' => 'igniter.pages::default.menu.label_menu_code',
                'description' => 'igniter.pages::default.menu.help_menu_code',
                'type' => 'select',
                'validationRule' => 'required|alpha_dash',
            ],
        ];
    }

    public static function getCodeOptions()
    {
        return Menu::lists('name', 'code')->all();
    }

    public function onRun()
    {
        $this->page['menuItems'] = $this->menuItems();
    }

    public function menuItems()
    {
        if (!is_null($this->menuItems)) {
            return $this->menuItems;
        }

        if (!strlen($code = $this->property('code'))) {
            return [];
        }

        if ($menu = $this->getMenu()) {
            $this->menuName = $menu->name;
            $this->menuItems = resolve(MenuManager::class)->generateReferences($menu, $this->page);
        }

        return $this->menuItems ?? [];
    }

    public function resetMenu($code)
    {
        $this->setProperty('code', $code);
        $this->menuItems = null;

        return $this->page['menuItems'] = $this->menuItems();
    }

    /**
     * @return \Igniter\Pages\Models\Menu
     */
    protected function getMenu()
    {
        $code = $this->property('code');
        if (isset(self::$menuCache[$code])) {
            return self::$menuCache[$code];
        }

        $menu = Menu::with(['items'])->whereCode($code)->first();

        return self::$menuCache[$code] = $menu;
    }
}
