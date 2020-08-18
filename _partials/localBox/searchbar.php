<form
    id="location-search"
    method="POST"
    role="form"
    data-request="<?= $searchEventHandler; ?>"
>
    <div class="input-group">
        <div class="input-group-prepend">
            <span
                class="input-group-text"
            ><i class="fa fa-map-marker"></i></span>
        </div>
        <input
            type="text"
            id="search-query"
            class="form-control text-center"
            name="search_query"
            placeholder="<?= lang('igniter.local::default.label_search_query'); ?>"
            value="<?= $location->userPosition()->isValid() ? trim($location->userPosition()->format()) : ''; ?>"
        >
        <div class="input-group-append">
            <button
                type="button"
                class="btn btn-light"
                data-control="search-local"
                data-replace-loading="fa fa-spinner fa-spin"
            ><i class="fa fa-check"></i></button>
        </div>
    </div>
</form>
