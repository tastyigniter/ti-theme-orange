<div class="layout-scrollable w-100">
    <ul class="nav nav-pills nav-inline flex-nowrap py-3 w-100">
        <li class="nav-item">
            <a
                @class(['nav-link rounded-pill py-1 text-nowrap', 'active fw-bold' => !$selectedCategory])
                href="{{ page_url('local/menus', ['category' => null]) }}"
                wire:navigate
            >@lang('igniter.local::default.text_all_categories')</a>
        </li>

        @foreach ($categories->toFlatTree() as $category)
            @continue(in_array($category->getKey(), $hiddenCategories))
            @continue($hideEmptyCategory && $category->count_menus < 1)

            <li class="nav-item">
                <a
                    @class(['nav-link rounded-pill py-1', 'active fw-bold' => ($selectedCategory && $category->permalink_slug == $selectedCategory->permalink_slug)])
                    href="{{ page_url('local/menus', ['category' => $category->permalink_slug]) }}"
                    wire:navigate
                >{{ $category->name }}</a>
            </li>
        @endforeach
    </ul>
</div>
