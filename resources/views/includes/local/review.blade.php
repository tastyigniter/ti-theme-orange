<blockquote>
    <p class="review-text">{{ $review->review_text }}</p>
    <div class="rating-row row">
        <div class="col col-md-4">
            <span class="text-muted"><b>Quality:</b></span>
            <div
                data-control="star-rating"
                data-score="{{ $review->quality }}"
                data-hints='@json($reviewRatingHints)'
                data-score-name="Quality"
                data-read-only="true"
            >
                <div class="rating rating-star text-warning"></div>
            </div>
        </div>
        <div class="col col-md-4">
            <span class="text-muted"><b>Delivery:</b></span>
            <div
                data-control="star-rating"
                data-score="{{ $review->delivery }}"
                data-hints='@json($reviewRatingHints)'
                data-score-name="Delivery"
                data-read-only="true"
            >
                <div class="rating rating-star text-warning"></div>
            </div>
        </div>
        <div class="col col-md-4">
            <span class="text-muted"><b>Service:</b></span>
            <div
                data-control="star-rating"
                data-score="{{ $review->service }}"
                data-hints='@json($reviewRatingHints)'
                data-score-name="Service"
                data-read-only="true"
            >
                <div class="rating rating-star text-warning"></div>
            </div>
        </div>
    </div>
    <small>
        {{ $review->customer->full_name }} @lang('igniter.local::default.text_from')
        <cite title="@lang('igniter.local::default.text_source')">
            {{ $review->customer->address ? $review->customer->address->city : '' }}
        </cite>
        @lang('igniter.local::default.text_on')
        {{ $review->created_at->isoFormat(lang('system::lang.moment.date_format_short')) }}
    </small>
</blockquote>
