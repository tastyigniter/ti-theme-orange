<div class="card mb-3">
    <div class="card-body">
        <form
            method="GET"
            id="filter-search-form"
            class="form-search form-horizontal"
            action="<?= current_url(); ?>"
        >
            <div class="input-group">
                <input
                    type="search"
                    class="form-control"
                    name="search"
                    value="<?= $filterSearch; ?>"
                    placeholder="<?= lang('igniter.local::default.text_filter_search'); ?>"
                />
                <span class="input-group-append">
                    <button class="btn btn-light" type="submit"><i class="fa fa-search"></i></button>
                </span>
            </div>
        </form>
    </div>
</div>