<?php

declare(strict_types=1);

namespace Igniter\Orange\Actions;

use Igniter\Cart\Models\Menu as MenuModel;
use Igniter\Orange\Data\MenuItemData;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ListMenuItems
{
    protected $hideUnavailable = false;

    protected Collection|LengthAwarePaginator $menuList;

    protected array $menuListCategories = [];

    public function hideUnavailable(bool $hideUnavailable = true): self
    {
        $this->hideUnavailable = $hideUnavailable;

        return $this;
    }

    public function handle(array $filters, array $with = []): self
    {
        $with = array_merge([
            'mealtimes', 'menu_options',
            'categories', 'special', 'ingredients',
            'menu_options.option', 'locations', 'stocks',
        ], $with);

        $menuList = MenuModel::query()->with($with)->listFrontEnd($filters);

        if (!array_key_exists('pageLimit', $filters)) {
            $menuList = $this->processMenuItems($menuList->get());
        } else {
            $menuList->setCollection($this->processMenuItems($menuList->getCollection()));
        }

        if (!strlen((string)array_get($filters, 'category')) && array_get($filters, 'isGrouped', false)) {
            if (!array_key_exists('pageLimit', $filters)) {
                $menuList = $this->groupListByCategory($menuList);
            } else {
                $menuList->setCollection($this->groupListByCategory($menuList->getCollection()));
            }
        }

        $this->menuList = $menuList;

        return $this;
    }

    public function getList(): Collection|LengthAwarePaginator
    {
        return $this->menuList;
    }

    public function getCategoryList(): array
    {
        return $this->menuListCategories;
    }

    protected function groupListByCategory($items)
    {
        $this->menuListCategories = [];

        $groupedList = [];
        foreach ($items as $menuItemObject) {
            $categories = $menuItemObject->model->categories;
            if (!$categories || $categories->isEmpty()) {
                $groupedList[0][] = $menuItemObject;
                continue;
            }

            foreach ($categories as $category) {
                $this->menuListCategories[$category->getKey()] = $category;
                $groupedList[$category->getKey()][] = $menuItemObject;
            }
        }

        return collect($groupedList)
            ->sortBy(function($menuItems, $categoryId) {
                if (isset($this->menuListCategories[$categoryId])) {
                    return $this->menuListCategories[$categoryId]->priority;
                }

                return $categoryId;
            });
    }

    protected function processMenuItems(Collection $menuList): Collection
    {
        return $menuList->map(fn($menuItem): MenuItemData => new MenuItemData($menuItem))
            ->when($this->hideUnavailable, function(Collection $menuList) {
                return $menuList->filter(fn(MenuItemData $menuItemData) => $menuItemData->mealtimeIsAvailable());
            });
    }
}
