@if ($__SELF__->menuItems())
    <ul>
        @themePartial($__SELF__.'::items', ['items' => $__SELF__->menuItems()])
    </ul>
@endif
