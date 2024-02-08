<div class="border-bottom">
    <x-igniter-orange::forms.form
        id="menu-search"
        wire:submit="$refresh"
    >
        <div class="input-group">
            <span
                class="bg-white d-inline-flex align-items-center py-1 px-2"
            ><i class="fa fa-search"></i></span>
            <input
                wire:model.live.debounce="menuSearchTerm"
                type="search"
                class="bg-white form-control py-2 border-0 shadow-none rounded-0"
                placeholder="@lang('igniter.local::default.label_menu_search')"
                autocomplete="off"
            >
            @if (strlen($menuSearchTerm))
                <a
                    wire:click="$set('menuSearchTerm', '')"
                    class="btn p-1"
                ><i class="fa fa-times"></i></a>
            @endif
        </div>
    </x-igniter-orange::forms.form>
</div>
