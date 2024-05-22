<?php

namespace Igniter\Orange\Livewire;

use Igniter\Admin\Classes\FormField;
use Igniter\Admin\Widgets\Form;
use Igniter\Cart\Models\Menu as MenuModel;
use Igniter\Local\Facades\Location;
use Igniter\Main\Traits\ConfigurableComponent;
use Igniter\Orange\Data\MenuItemData;
use Illuminate\Support\Collection;
use Livewire\Attributes\Url;
use Livewire\WithPagination;

class MenuItemList extends \Livewire\Component
{
    use ConfigurableComponent;
    use WithPagination;

    public bool $isGrouped = true;

    public int $collapseCategoriesAfter = 5;

    public int $itemsPerPage = 200;

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

    public static function componentMeta(): array
    {
        return [
            'code' => 'igniter-orange::menu-item-list',
            'name' => 'igniter.orange::default.component_menu_item_list_title',
            'description' => 'igniter.orange::default.component_menu_item_list_desc',
        ];
    }

    public function defineProperties(): array
    {
        return [
            'isGrouped' => [
                'label' => 'Group menu items by category.',
                'type' => 'switch',
                'span' => 'left',
                'validationRule' => 'required|boolean',
            ],
            'collapseCategoriesAfter' => [
                'label' => 'Collapse categories after the specified number of items in group view.',
                'type' => 'number',
                'span' => 'right',
                'validationRule' => 'required|numeric|min:0',
            ],
            'itemsPerPage' => [
                'label' => 'Number of menu items to display per page.',
                'type' => 'number',
                'span' => 'left',
                'validationRule' => 'required|numeric|min:0',
            ],
            'sortOrder' => [
                'label' => 'Default sort order of menu items.',
                'type' => 'select',
                'span' => 'right',
                'validationRule' => 'required|string',
            ],
            'showThumb' => [
                'label' => 'Display menu item, category and allergen image thumb.',
                'type' => 'switch',
                'validationRule' => 'required|boolean',
            ],
            'menuThumbWidth' => [
                'label' => 'Menu item image thumb width',
                'type' => 'number',
                'span' => 'left',
                'validationRule' => 'required|numeric|min:0',
            ],
            'menuThumbHeight' => [
                'label' => 'Menu item image thumb height',
                'type' => 'number',
                'span' => 'right',
                'validationRule' => 'required|numeric|min:0',
            ],
            'categoryThumbWidth' => [
                'label' => 'Category image thumb width.',
                'type' => 'number',
                'span' => 'left',
                'validationRule' => 'required|numeric|min:0',
            ],
            'categoryThumbHeight' => [
                'label' => 'Category image thumb height.',
                'type' => 'number',
                'span' => 'right',
                'validationRule' => 'required|numeric|min:0',
            ],
            'allergenThumbWidth' => [
                'label' => 'Allergen image thumb width.',
                'type' => 'number',
                'span' => 'left',
                'validationRule' => 'required|numeric|min:0',
            ],
            'allergenThumbHeight' => [
                'label' => 'Allergen image thumb height.',
                'type' => 'number',
                'span' => 'right',
                'validationRule' => 'required|numeric|min:0',
            ],
            'hideMenuSearch' => [
                'label' => 'Hide the menu search form',
                'type' => 'switch',
                'validationRule' => 'required|boolean',
            ],
        ];
    }

    public static function getPropertyOptions(Form $form, FormField $field): array|Collection
    {
        return match ($field->getConfig('property')) {
            'sortOrder' => collect(MenuModel::make()->queryModifierGetSorts())->mapWithKeys(function($value, $key) {
                return [$value => $value];
            })->all(),
            default => [],
        };
    }

    public function render()
    {
        return view('igniter-orange::livewire.menu-item-list', [
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
            $this->dispatch('cart-box:add-item', menuId: $menuId, quantity: $quantity);
        }
    }

    protected function loadList()
    {
        $location = Location::current()?->getKey();

        $filters = [
            'sort' => $this->sortOrder,
            'location' => $location,
            'category' => $this->selectedCategorySlug,
            'search' => $this->menuSearchTerm,
            'orderType' => Location::orderType(),
        ];

        if ($this->itemsPerPage > 0) {
            $filters['page'] = $this->getPage();
            $filters['pageLimit'] = $this->itemsPerPage;
        }

        $list = MenuModel::with([
            'mealtimes', 'menu_options',
            'categories' => function($query) use ($location) {
                $query->whereHasOrDoesntHaveLocation($location);
            }, 'categories.media',
            'special', 'media', 'ingredients.media',
            'menu_options.option',
        ])->listFrontEnd($filters);

        if ($this->itemsPerPage > 0) {
            $list->setCollection($list->getCollection()
                ->map(fn($menuItem) => new MenuItemData($menuItem)));
        } else {
            $list = $list->get()->map(fn($menuItem) => new MenuItemData($menuItem));
        }

        if (!strlen($this->selectedCategorySlug) && $this->isGrouped) {
            if ($this->itemsPerPage > 0) {
                $list->setCollection($this->groupListByCategory($list->getCollection()));
            } else {
                $list = $this->groupListByCategory($list);
            }
        }

        return $list;
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
}
