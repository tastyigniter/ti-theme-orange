<div class="module-box">
    @if ($banner)
        @if ($banner->isCustom)
            {!! $banner->value !!}
        @else
            @partial('@images', ['banner' => $banner])
        @endif
    @endif
</div>