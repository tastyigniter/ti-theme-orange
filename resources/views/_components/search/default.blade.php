<div id="local-box" class="local-box-fluid">
    <div class="panel panel-local local-search">
        <div class="panel-body">
            @if ($hideSearch)
                <a
                        class="btn btn-block btn-primary"
                        href="{{ restaurant_url($menusPage) }}"
                >@lang('igniter.local::default.text_find')</a>
            @else
                <h2 class="text-center text-primary">@lang('igniter.local::default.text_order_summary')</h2>
                <span class="search-label sr-only">@lang('igniter.local::default.label_search_query')</span>
                <div id="local-search-container">
                    @themePartial('@container')
                </div>
            @endif
        </div>
    </div>
</div>
