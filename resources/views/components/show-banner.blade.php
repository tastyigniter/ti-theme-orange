<div class="module-box">
    @if ($banner)
        @if ($banner->isCustom)
            {!! $banner->value !!}
        @else
            @themePartial('@images', ['banner' => $banner])
        @endif
    @endif
</div>
