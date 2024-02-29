<?php

namespace Igniter\Orange\View\Components;

use Igniter\Cart\Models\Category;
use Igniter\Local\Facades\Location;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class CategoriesList extends Component
{
    protected static ?Collection $categoriesCache = null;

    protected static ?Category $selectedCategoryCache = null;

    public function __construct(
        public string $menusPage = 'local'.DIRECTORY_SEPARATOR.'menus',
        public bool $hideEmptyCategory = false
    ) {
    }

    public function render()
    {
        return view('igniter-orange::components.categories-list', [
            'categories' => $this->loadCategories(),
            'selectedCategory' => $this->findSelectedCategory(),
        ]);
    }

    protected function loadCategories()
    {
        if (!is_null(self::$categoriesCache)) {
            return self::$categoriesCache;
        }

        $query = Category::with(['children', 'children.children'])->whereIsEnabled()->sorted();

        if ($location = Location::current()) {
            $query->whereHasOrDoesntHaveLocation($location->getKey());
        }

        return self::$categoriesCache = $query->get();
    }

    protected function findSelectedCategory()
    {
        if (!strlen($slug = request()->route()->parameter('category', ''))) {
            return null;
        }

        if (!is_null(self::$selectedCategoryCache)) {
            return self::$selectedCategoryCache;
        }

        $query = Category::whereIsEnabled()->where('permalink_slug', $slug);
        if ($location = Location::current()) {
            $query->whereHasOrDoesntHaveLocation($location->getKey());
        }

        return self::$selectedCategoryCache = $query->first();
    }
}
