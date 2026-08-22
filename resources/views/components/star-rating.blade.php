<div
    {{ $attributes }}
>
    @if($readOnly && isset($max))
        @php($displayScore = floor($score * 2) / 2)
        @for ($value = 1; $value<($max+1); $value++)
            @php($isHalfStar = ($value - 0.5) === $displayScore)
            <span @class([
                'fa-star' => !$isHalfStar,
                'fa-star-half' => $isHalfStar,
                'fa' => $value <= $displayScore || $isHalfStar,
                'far' => $value > $displayScore && !$isHalfStar,
             ])></span>
        @endfor
    @elseif(isset($hints))
        <div
            wire:ignore
            data-control="star-rating"
            data-hints='@json($hints)'
            data-score-name="{{ $name }}"
        >
            <div class="rating rating-star text-warning"></div>
        </div>
    @endif

    {{ $slot }}
</div>
