<div>
    <div id="local-search-form">
        <x-igniter-orange::forms.form id="location-search" wire:submit="onSearchNearby">
            <div class="input-group input-group-lg bg-white rounded border p-1 mb-3 mb-lg-0">
                <input
                    wire:model="searchQuery"
                    type="text"
                    id="search-query"
                    class="bg-white form-control shadow-none border-none"
                    placeholder="@lang('igniter.local::default.label_search_query')"
                />
                <button
                    type="submit"
                    class="btn btn-primary btn-lg fw-bold ms-lg-3 rounded"
                    data-control="search-local"
                    wire:loading.class="disabled"
                >@lang('igniter.local::default.button_search_location')</button>
            </div>
        </x-igniter-orange::forms.form>
    </div>

    <x-igniter-orange::forms.error
        field="searchQuery"
        id="searchQueryFeedback"
        class="p-2 text-center text-danger fw-bold"
    />

    @include('igniter-orange::includes.local.saved-address-picker')
</div>
