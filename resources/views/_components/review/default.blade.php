@if (count($reviewList))
    <ul class="list-group list-group-flush">
        @foreach ($reviewList as $review)
            <li class="list-group-item review-item">
                @themePartial('@item', ['review' => $review])
            </li>
        @endforeach

        <li class="list-group-item">
            <div class="pagination-bar text-right">
                <div class="links">{!! $reviewList->links() !!}</div>
            </div>
        </li>

    </ul>
@else
    <div class="panel-body">
        <p>@lang('igniter.local::default.review.text_no_review')</p>
    </div>
@endif
