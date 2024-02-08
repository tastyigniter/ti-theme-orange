<div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title ms-auto" id="localReviewModalLabel">@lang('main::lang.local.text_tab_review')</h3>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <h1 class="h5">{{ sprintf(lang('igniter.local::default.review.text_review_heading'), $name) }}</h1>

            @if (count($reviewList))
                <ul class="list-group list-group-flush">
                    @foreach ($reviewList as $review)
                        <li class="list-group-item review-item px-0">
                            @include('igniter-orange::includes.local.review')
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
        </div>
    </div>
</div>
