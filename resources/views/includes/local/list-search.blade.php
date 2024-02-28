<div class="input-group input-group-lg bg-white rounded border p-1 mb-3 mb-lg-0">
<input
        wire:model.live="search"
        wire:loading.attr="disabled"
        type="search"
        class="bg-white form-control shadow-none border-none"
        name="search"
        placeholder="@lang('igniter.local::default.text_filter_search')"
    />
    <button
        class="btn btn-secondary btn-lg fw-bold ms-lg-3 rounded"
        type="button"
    ><i class="fa fa-search"></i></button>
</div>
