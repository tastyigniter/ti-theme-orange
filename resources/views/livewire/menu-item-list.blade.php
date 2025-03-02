<div>
    <div class="menu-search pb-4">
        @include('igniter-orange::includes.menu.search')
    </div>

    <div class="menu-list">
        @if (!$selectedCategorySlug && $isGrouped)
            @include('igniter-orange::includes.menu.grouped', ['groupedMenuItems' => $menuList])
        @else
            @include('igniter-orange::includes.menu.items', ['menuItems' => $menuList])
        @endif

        @if($itemsPerPage > 0)
            <div class="pagination-bar text-right">
                <div class="links">{{ $menuList->links() }}</div>
            </div>
        @endif
    </div>
</div>
