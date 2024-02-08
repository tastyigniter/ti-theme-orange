<?php

namespace Igniter\Orange\Livewire;

use Igniter\Cart\Models\Menu as MenuModel;
use Igniter\Local\Facades\Location;
use Igniter\Orange\Data\MenuItemData;
use Livewire\Attributes\Url;
use Livewire\WithPagination;

class ListMenuItems extends \Livewire\Component
{
    use WithPagination;

    public bool $isGrouped = true;

    public int $collapseCategoriesAfter = 5;

    public int $menusPerPage = 200;

    public string $sortOrder = 'menu_priority asc';

    public bool $showThumb = true;

    public int $menuThumbWidth = 95;

    public int $menuThumbHeight = 80;

    public int $categoryThumbWidth = 1240;

    public int $categoryThumbHeight = 256;

    public int $allergenThumbWidth = 28;

    public int $allergenThumbHeight = 28;

    public string $selectedCategorySlug = '';

    public bool $hideMenuSearch = false;

    #[Url(as: 'q')]
    public string $menuSearchTerm = '';

    protected array $menuListCategories = [];

    public function render()
    {
        return view('igniter-orange::livewire.list-menu-items', [
            'menuList' => $this->loadList(),
            'menuListCategories' => $this->menuListCategories,
        ]);
    }

    public function mount()
    {
        $this->selectedCategorySlug = request()->route()->parameter('category', '');
    }

    public function onAddToCart(int $menuId, int $quantity, bool $openModal = false)
    {
        if ($openModal) {
            $this->dispatch('openModal', component: 'igniter-orange::cart-item-modal', arguments: [
                'menuId' => $menuId,
                'quantity' => $quantity,
            ]);
        } else {
            $this->dispatch('cart-box::add-item', menuId: $menuId, quantity: $quantity);
        }
    }

    protected function loadList()
    {
        $location = Location::current()?->getKey();

        $list = MenuModel::with([
            'mealtimes', 'menu_options',
            'categories' => function ($query) use ($location) {
                $query->whereHasOrDoesntHaveLocation($location);
            }, 'categories.media',
            'special', 'media', 'ingredients.media',
            'menu_options.option',
        ])->listFrontEnd([
            'page' => $this->getPage(),
            'pageLimit' => $this->menusPerPage,
            'sort' => $this->sortOrder,
            'location' => $location,
            'category' => $this->selectedCategorySlug,
            'search' => $this->menuSearchTerm,
            'orderType' => Location::orderType(),
        ]);

        $list->setCollection($list->getCollection()
            ->map(fn($menuItem) => new MenuItemData($menuItem)));

        if (!strlen($this->selectedCategorySlug) && $this->isGrouped) {
            $this->groupListByCategory($list);
        }

        return $list;
    }

    protected function groupListByCategory($list)
    {
        $this->menuListCategories = [];

        $groupedList = [];
        foreach ($list->getCollection() as $menuItemObject) {
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

        $collection = collect($groupedList)
            ->sortBy(function ($menuItems, $categoryId) {
                if (isset($this->menuListCategories[$categoryId])) {
                    return $this->menuListCategories[$categoryId]->priority;
                }

                return $categoryId;
            });

        $list->setCollection($collection);
    }
}
