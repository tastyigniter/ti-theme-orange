@if (!$hideSearch)
    <div
            id="local-search-form"
            @class(['hide' => $localSearch->showAddressPicker()])
    >
        @themePartial('@form')
    </div>

    @if ($__SELF__->showAddressPicker())
        @themePartial('@address_picker')
    @endif

    @if ($__SELF__->showDeliveryCoverageAlert())
        <p class="help-block text-center mt-1 mb-0">@lang('igniter.local::default.text_delivery_coverage')</p>
    @endif
@endif
