<?php

namespace Igniter\Frontend\Models;

class Menus_model extends \Igniter\Cart\Models\Menus_model
{
    public static function getByIds($options = [])
    {
        extract(array_merge([
            'pageLimit' => 20,
            'sort' => 'menu_priority asc',
            'menuIds' => [],
        ], $options));

        if (!is_array($menuIds)) {
            $menuIds = [$menuIds];
        }

        $query = self::with('locations')->whereIn('menu_id', $menuIds);

        if (!is_array($sort)) {
            $sort = [$sort];
        }

        foreach ($sort as $_sort) {
            $parts = explode(' ', $_sort);
            if (count($parts) < 2) {
                array_push($parts, 'desc');
            }
            [$sortField, $sortDirection] = $parts;
            $query->orderBy($sortField, $sortDirection);
        }

        return $query->take($pageLimit)->get();
    }
}
