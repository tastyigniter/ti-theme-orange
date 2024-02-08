<div class="input-group input-group-lg">
    <input
        wire:model.blur="search"
        wire:loading.attr="disabled"
        type="search"
        class="bg-white form-control rounded-pill"
        name="search"
        placeholder="@lang('igniter.local::default.text_filter_search')"
    />
    <button
        class="btn btn btn-secondary rounded-pill ms-2"
        type="submit"
    ><i class="fa fa-search"></i></button>
</div>
