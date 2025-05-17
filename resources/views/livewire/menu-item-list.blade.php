<div>
    @unless($hideMenuSearch)
        <div class="menu-search pb-4">
            @include('igniter-orange::includes.menu.search')
        </div>
    @endunless

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

    @if($selectedMenuId)
        <button
            x-data="OrangeShowSelectedMenuItemModal()"
            x-ref="selectedMenuItemTrigger"
            type="button"
            class="d-none"
            data-toggle="orange-modal"
            data-component="igniter-orange::cart-item-modal"
            data-arguments='{"menuId": {{ $selectedMenuId }}}'
        ></button>
    @endif
</div>

@script
<script>
    document.addEventListener('livewire:initialized', () => {
        document.querySelectorAll('[data-control="menu-item"]').forEach((el) => {
            el.addEventListener('click', (event) => {
                if (el.classList.contains('disabled')) {
                    event.preventDefault();
                    return;
                } else {
                    el.classList.add('disabled');
                }

                el.querySelectorAll('i').forEach((icon) => {
                    if (icon.hasAttribute('wire:loading.class')) {
                        icon.classList.add('fa-spinner', 'fa-spin');
                    }
                });
            });
        });
    })
    Livewire.hook('commit', ({respond}) => {
        respond(() => {
            document.querySelectorAll('[data-control="menu-item"]').forEach((el) => {
                el.classList.remove('disabled');
                el.querySelectorAll('i.fa-spin').forEach((icon) => {
                    if (icon.hasAttribute('wire:loading.class')) {
                        icon.classList.remove('fa-spinner', 'fa-spin');
                    }
                })
            });
        })
    });
</script>
@endscript
