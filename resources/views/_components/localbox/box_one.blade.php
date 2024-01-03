@if ($showLocalThumb && $locationCurrent->hasMedia('thumb'))
    <img
            class="img-fluid pull-left"
            src="{{ $locationCurrent->getThumb(['width' => $localThumbWidth, 'height' => $localThumbHeight]) }}"
    />
@endif
<dl class="no-spacing">
    <dd><h1 class="h3">{{ $locationCurrent->getName() }}</h1></dd>
    @if ($showReviews)
        <dd class="text-muted">
            <div class="rating rating-sm">
                @php $reviewScore = $locationCurrent->reviews_score() @endphp @for ($value = 1; $value<6; $value++)
                    <span @class(['fa-star', 'fa' => $value <= $reviewScore, 'far' => $value > $reviewScore])></span>
                @endfor
                <span class="small">({{ $locationCurrent->reviews_count ?? 0 }})</span>
            </div>
        </dd>
    @endif
    <dd>
        <span class="text-muted">{{ format_address($locationCurrent->getAddress(), false) }}</span>
    </dd>
</dl>
