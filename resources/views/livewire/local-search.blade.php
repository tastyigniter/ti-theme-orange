<div>
    <div id="local-search-form">
        <x-igniter-orange::forms.form id="location-search" wire:submit="onSearchNearby">
            <div class="d-lg-flex">
                <div class="input-group input-group-lg mb-3 mb-lg-0">
                    <input
                        wire:model="searchQuery"
                        type="text"
                        id="search-query"
                        class="bg-white form-control text-center rounded-pill"
                        name="searchQuery"
                        placeholder="@lang('igniter.local::default.label_search_query')"
                        value="{{ $this->getSearchQuery() }}"
                    />
                </div>
                <button
                    type="button"
                    class="btn btn-primary btn-lg fw-bold ms-lg-3 rounded-pill"
                    data-control="search-local"
                    wire:loading.class="disabled"
                >@lang('igniter.local::default.button_search_location')</button>
            </div>
        </x-igniter-orange::forms.form>
    </div>

    @if ($this->showDeliveryCoverageAlert())
        <p class="help-block text-center mt-1 mb-0">@lang('igniter.local::default.text_delivery_coverage')</p>
    @endif
</div>
