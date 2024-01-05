<div id="address-book">
    @if ($addressIdParam)
        @themePartial('@form')
    @else
        @themePartial('@list')
    @endif
</div>
