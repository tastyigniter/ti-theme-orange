<?php

namespace Igniter\Pages;

use Igniter\Pages\Classes\Page as StaticPage;
use Igniter\Pages\Classes\PageManager;
use Igniter\Pages\Models\Menu;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Event;

class Extension extends \System\Classes\BaseExtension
{
    public function boot()
    {
        Event::listen('main.theme.activated', function () {
            Menu::syncAll();
        });

        Event::listen('router.beforeRoute', function ($url) {
            return PageManager::instance()->initPage($url);
        });

        Event::listen('main.page.beforeRenderPage', function ($controller, $page) {
            $contents = PageManager::instance()->getPageContents($page);
            if (strlen($contents)) {
                return $contents;
            }
        });

        Event::listen('pages.menuitem.listTypes', function () {
            return [
                'static-page' => 'igniter.pages::default.menu.text_static_page',
                'all-static-pages' => 'igniter.pages::default.menu.text_all_static_pages',
            ];
        });

        Event::listen('pages.menuitem.getTypeInfo', function ($type) {
            if ($type == 'url' || $type == 'header') {
                return [];
            }

            return StaticPage::getMenuTypeInfo($type);
        });

        Event::listen('pages.menuitem.resolveItem', function ($item, $url, $theme) {
            if ($item->type == 'static-page' || $item->type == 'all-static-pages') {
                return StaticPage::resolveMenuItem($item, $url, $theme);
            }
        });

        Relation::morphMap([
            'pages' => \Igniter\Pages\Models\Pages_model::class,
        ]);
    }

    public function registerComponents()
    {
        return [
            \Igniter\Pages\Components\StaticPage::class => [
                'code' => 'staticPage',
                'name' => 'lang:igniter.pages::default.text_component_title',
                'description' => 'lang:igniter.pages::default.text_component_desc',
            ],
            \Igniter\Pages\Components\StaticMenu::class => [
                'code' => 'staticMenu',
                'name' => 'lang:igniter.pages::default.menu.text_component_title',
                'description' => 'lang:igniter.pages::default.menu.text_component_desc',
            ],
        ];
    }

    public function registerNavigation()
    {
        return [
            'design' => [
                'child' => [
                    'pages' => [
                        'priority' => 15,
                        'class' => 'pages',
                        'href' => admin_url('igniter/pages/pages'),
                        'title' => lang('admin::lang.side_menu.page'),
                        'permission' => 'Igniter.Pages.*',
                    ],
                ],
            ],
        ];
    }

    public function registerPermissions()
    {
        return [
            'Igniter.Pages.Manage' => [
                'group' => 'module',
                'description' => 'Create, modify and delete front-end pages and menus',
            ],
        ];
    }
}
