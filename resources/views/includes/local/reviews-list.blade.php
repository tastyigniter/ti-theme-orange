@if (count($reviewList))
    <ul class="list-group list-group-flush">
        @foreach ($reviewList as $review)
            <li class="list-group-item review-item">
                <blockquote>
                    <p class="review-text">{{ $review->review_text }}</p>
                    <div class="rating-row row">
                        <div class="col col-md-4">
                            <span class="text-muted"><b>Quality:</b></span>
                            <x-igniter-orange::star-rating :score="$review->quality" name="quality" class="text-warning" />
                        </div>
                        <div class="col col-md-4">
                            <span class="text-muted"><b>Delivery:</b></span>
                            <x-igniter-orange::star-rating :score="$review->delivery" name="delivery" class="text-warning" />
                        </div>
                        <div class="col col-md-4">
                            <span class="text-muted"><b>Service:</b></span>
                            <x-igniter-orange::star-rating :score="$review->service" name="service" class="text-warning" />
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
            </li>
        @endforeach

        <li class="list-group-item">
            <div class="pagination-bar text-right">
                <div class="links">{!! $reviewList->links() !!}</div>
            </div>
        </li>
    </ul>
@else
    <p>@lang('igniter.local::default.review.text_no_review')</p>
@endif
