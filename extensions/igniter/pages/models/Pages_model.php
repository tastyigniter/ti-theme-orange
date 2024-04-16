<?php

namespace Igniter\Pages\Models;

use Igniter\Flame\Database\Traits\Sortable;
use Main\Classes\ThemeManager;
use Main\Template\Layout;

/**
 * Pages Model Class
 */
class Pages_model extends \System\Models\Pages_model
{
    use Sortable;

    const SORT_ORDER = 'priority';

    public function getLayoutOptions()
    {
        $result = [];
        $theme = ThemeManager::instance()->getActiveTheme();
        $layouts = Layout::listInTheme($theme, true);
        foreach ($layouts as $layout) {
            if (!$layout->hasComponent('staticPage')) {
                continue;
            }

            $baseName = $layout->getBaseFileName();
            $result[$baseName] = strlen($layout->description) ? $layout->description : $baseName;
        }

        return $result;
    }

    public function getLayoutObject()
    {
        if (!$layoutId = $this->layout) {
            $layouts = $this->getLayoutOptions();
            $layoutId = count($layouts) ? array_keys($layouts)[0] : null;
        }

        if (!$layoutId) {
            return null;
        }

        if (!$layout = Layout::load($this->theme, $layoutId)) {
            return null;
        }

        return $layout;
    }

    public function getContentAttribute($value)
    {
        return html_entity_decode($value);
    }

    public function getMorphClass()
    {
        return 'pages';
    }
}
