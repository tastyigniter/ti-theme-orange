@if ($__SELF__->resetCode())
    @themePartial('@reset')
@else
    @themePartial('@forgot')
@endif
