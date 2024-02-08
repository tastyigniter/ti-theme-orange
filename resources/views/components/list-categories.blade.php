<div class="layout-scrollable w-100">
    <ul class="nav nav-pills nav-inline flex-nowrap py-3 w-100">
        <li class="nav-item">
            <a
                @class(['nav-link rounded-pill py-1 text-nowrap', 'active fw-bold' => !$selectedCategory])
                href="{{ page_url('local/menus', ['category' => null]) }}"
                wire:navigate
            >@lang('igniter.local::default.text_all_categories')</a>
        </li>

        @include('igniter-orange::includes.menu.categories', [
            'categories' => $categories->toFlatTree(),
            'displayAsFlatTree' => true
        ])
    </ul>
</div>
