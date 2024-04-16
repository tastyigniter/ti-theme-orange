<?php

namespace Igniter\Pages\Classes;

use Igniter\Pages\Models\Pages_model;
use Illuminate\Support\Facades\URL;
use Main\Classes\Theme;

class Page extends \Main\Template\Page
{
    /**
     * Handler for the pages.menuitem.getTypeInfo event.
     *
     * @return array
     */
    public static function getMenuTypeInfo(string $type)
    {
        if ($type == 'all-static-pages') {
            return [];
        }

        if ($type == 'static-page') {
            return [
                'references' => self::listStaticPageMenuOptions(),
            ];
        }
    }

    /**
     * Handler for the pages.menuitem.resolveItem event.
     * @param \Igniter\Pages\Models\MenuItem $item
     * @return array|void
     */
    public static function resolveMenuItem($item, string $url, Theme $theme)
    {
        $query = Pages_model::isEnabled()->orderBy('title');

        if ($item->type == 'static-page') {
            $query->where('page_id', $item->reference);
        }

        $pages = $query->get();
        if ($pages->isEmpty()) {
            return;
        }

        $result = [];

        if ($item->type == 'static-page') {
            $page = $pages->first();
            $result['url'] = URL::to($page->permalink_slug);
            $result['isActive'] = rawurldecode($result['url']) === rawurldecode($url);
        } else {
            $items = [];
            foreach ($pages as $page) {
                if (array_get($page->metadata, 'navigation_hidden', false)) {
                    continue;
                }

                $pageUrl = URL::to($page->permalink_slug);
                $items[] = [
                    'title' => $page->title,
                    'url' => $pageUrl,
                    'isActive' => rawurldecode($pageUrl) === rawurldecode($url),
                ];
            }
            $result['items'] = $items;
        }

        return $result;
    }

    protected static function listStaticPageMenuOptions()
    {
        $references = [];

        $pages = Pages_model::isEnabled()->orderBy('title')->get();
        foreach ($pages as $page) {
            $references[$page->page_id] = $page->title;
        }

        return $references;
    }
}
