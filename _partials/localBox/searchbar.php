---
description: ''
---
<script>
    document.addEventListener("DOMContentLoaded", function (event) {
        initAutocomplete(document.getElementById('search-query'), document.getElementById('search-query-button'));
        document.getElementById('search-query').style.maxWidth = ((document.getElementById('search-query').value.length) - 2) + 'ch';

        document.getElementById('search-site').style.maxWidth = ((document.getElementById('search-query').value.length) - 2) + 'ch !important';

    });
</script>
<div>
    <form id="location-search"
          class="float-right clear-both"
          method="POST"
          role="form"
          data-request="<?= $searchEventHandler; ?>">
        <div class="input-group">
            <!--        <div class="input-group-prepend">-->
            <!--            <span class="input-group-text">-->
            <!--                <i class="fa fa-map-marker"></i>-->
            <!--            </span>-->
            <!--        </div>-->
            <div class="input-group-append">
                <button
                        id="search-query-button"
                        type="button"
                        class="btn btn-light smoova-search-button"
                        data-control="search-local"
                        data-replace-loading="fa fa-spinner fa-spin">
                    <i class="fa fa-map-marker"></i>
                    <!--                <i class="fa fa-check"></i>-->
                </button>
            </div>
            <input data-search-action="<?= $searchEventHandler; ?>"
                   data-search-ready="false"
                   type="text"
                   id="search-query"
                   autocomplete="off"
                   class="form-control smoova-location-input"
                   name="search_query"
                   oninput="this.style.minWidth = ((this.value.length + 1) * 8) + 'px';"
                   placeholder="<?= lang('igniter.local::default.label_search_query'); ?>"
                   value="<?= $location->userPosition()->isValid() ? $location->userPosition()->getFullAddress() : ''; ?>"
            >

            <input type="hidden" id="search-query-coordinates" name="search_query_coordinates" value="">

        </div>
    </form>
</div>
