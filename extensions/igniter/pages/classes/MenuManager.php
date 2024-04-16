<?php

namespace Igniter\Pages\Classes;

use Igniter\Flame\Support\Facades\File;
use Igniter\Flame\Traits\Singleton;
use Igniter\Pages\Models\Menu;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\URL;
use System\Models\Themes_model;

class MenuManager
{
    use Singleton;

    protected static $themesCache;

    protected $defaultMenuItem = [
        'code' => null,
        'title' => null,
        'url' => null,
        'isActive' => false,
        'isChildActive' => false,
        'extraAttributes' => false,
        'items' => [],
    ];

    public function getMenusConfig()
    {
        $menus = [];
        $themes = Themes_model::isEnabled()->get();
        foreach ($themes as $theme) {
            $files = File::glob($configPath = $theme->getTheme()->getPath().'/_meta/menus/*.php');
            foreach ($files as $file) {
                $config = File::getRequire($file);
                $menus[] = [
                    'code' => basename($file, '.php'),
                    'name' => array_get($config, 'name', '-- no name --'),
                    'themeCode' => $theme->code,
                    'items' => array_get($config, 'items', []),
                ];
            }
        }

        return $menus;
    }

    public function generateReferences(Menu $menu, $page)
    {
        if (!strlen($currentUrl = Request::path())) {
            $currentUrl = '/';
        }

        $currentUrl = strtolower(URL::to($currentUrl));
        $activeMenuItem = $page->activeMenuItem ?: false;

        $iterator = function ($items) use (&$iterator, $currentUrl, $activeMenuItem, $menu) {
            $result = [];

            foreach ($items as $item) {
                $parentReference = (object)$this->defaultMenuItem;
                $parentReference->code = $item->code;
                $parentReference->title = $item->title;
                $parentReference->extraAttributes = array_get($item->config, 'extraAttributes');

                if ($item->type == 'url') {
                    $parentReference->url = $item->url;
                    $parentReference->isActive = $currentUrl == strtolower(URL::to($item->url)) || $activeMenuItem === $item->code;
                } else {
                    $parentReference = $this->resolveItem(
                        $menu, $item, $parentReference, $currentUrl, $activeMenuItem
                    );
                }

                if (count($item->children)) {
                    $parentReference->items = $iterator($item->children);
                }

                $result[] = $parentReference;
            }

            return $result;
        };

        $items = $iterator($menu->items()->sorted()->get()->toTree());

        $hasActiveChild = function ($items) use (&$hasActiveChild) {
            foreach ($items as $item) {
                if ($item->isActive) {
                    return true;
                }

                $result = $hasActiveChild($item->items);
                if ($result) {
                    return $result;
                }
            }
        };

        $iterator = function ($items) use (&$iterator, &$hasActiveChild) {
            foreach ($items as $item) {
                $item->isChildActive = $hasActiveChild($item->items);
                $iterator($item->items);
            }
        };

        $iterator($items);

        Event::fire('pages.menu.referencesGenerated', [&$items]);

        return $items;
    }

    protected function resolveItem($menu, $item, $parentReference, $currentUrl, $activeMenuItem)
    {
        $theme = $this->getThemeFromMenu($menu);

        $response = Event::fire('pages.menuitem.resolveItem', [$item, $currentUrl, $theme]);

        if (is_array($response)) {
            foreach ($response as $itemInfo) {
                if (!is_array($itemInfo)) {
                    continue;
                }

                if (isset($itemInfo['url'])) {
                    $parentReference->url = $itemInfo['url'];
                    $parentReference->isActive = $itemInfo['isActive'] || $activeMenuItem === $item->code;
                }

                if (isset($itemInfo['items'])) {
                    $itemIterator = function ($items) use (&$itemIterator, $parentReference) {
                        $result = [];
                        foreach ($items as $item) {
                            $reference = (object)$this->defaultMenuItem;
                            $reference->code = array_get($item, 'code', null);
                            $reference->title = array_get($item, 'title', '-- no title --');
                            $reference->url = array_get($item, 'url', '#');
                            $reference->isActive = array_get($item, 'isActive', false);
                            $reference->extraAttributes = array_get($item, 'extraAttributes');

                            if (!strlen($parentReference->url)) {
                                $parentReference->url = $reference->url;
                                $parentReference->isActive = $reference->isActive;
                            }

                            if (isset($item['items'])) {
                                $reference->items = $itemIterator($item['items']);
                            }

                            $result[] = $reference;
                        }

                        return $result;
                    };

                    $parentReference->items = $itemIterator($itemInfo['items']);
                }
            }
        }

        return $parentReference;
    }

    protected function getThemeFromMenu($menu)
    {
        $code = $menu->theme_code;
        if (isset(self::$themesCache[$code])) {
            return self::$themesCache[$code];
        }

        return self::$themesCache[$code] = $menu->theme->getTheme();
    }
}
