@foreach ($categories as $category)
    @continue(in_array($category->getKey(), $hiddenCategories))
    @continue($hideEmptyCategory && $category->count_menus < 1)

    <li class="nav-item">
        <a
            @class(['nav-link rounded-pill py-1', 'active fw-bold' => ($selectedCategory && $category->permalink_slug == $selectedCategory->permalink_slug)])
            href="{{ page_url('local/menus', ['category' => $category->permalink_slug]) }}"
            wire:navigate
        >{{ $category->name }}</a>

        @if ((!isset($displayAsFlatTree) || !$displayAsFlatTree) && count($category->children))
            <ul class="nav flex-column ms-3 my-1">
                @include('igniter-orange::includes.categories.items', ['categories' => $category->children])
            </ul>
        @endif
    </li>
@endforeach
