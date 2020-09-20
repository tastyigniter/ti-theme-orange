---
description: ''
---
<!--<div class="card mb-3">
    <div class="card-body"> -->
<div>
    <form
            method="GET"
            id="filter-search-form"
            class="form-search form-horizontal float-left clear-both"
            action="<?= current_url(); ?>">
        <div class="input-group">
                        <span class="input-group-append">
                    <button class="btn btn-light smoova-search-button" type="submit">
                        <i class="fa fa-search"></i>
                    </button>
            </span>
            <input autocomplete="off"
                   id="search-site"
                   type="search"
                   class="form-control smoova-location-input"
                   name="search"
                   oninput="this.style.minWidth = ((this.value.length + 1) * 8) + 'px';"
                   value="<?= $filterSearch; ?>"
                   placeholder="<?= lang('igniter.local::default.text_filter_search'); ?>"/>
        </div>
    </form>
</div>