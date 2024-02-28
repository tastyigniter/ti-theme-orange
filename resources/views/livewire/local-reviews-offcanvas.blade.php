<div class="offcanvas offcanvas-end w-100 w-md-50">
    <div class="offcanvas-header">
        <h3 class="offcanvas-title" id="localReviewModalLabel">
            {{ sprintf(lang('igniter.local::default.review.text_review_heading'), $locationName) }}
        </h3>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        @include('igniter-orange::includes.local.reviews-list')

        <button type="button" class="btn btn-primary w-100" data-bs-dismiss="offcanvas">
            @lang('igniter.orange::default.button_more_reviews')
        </button>
    </div>
</div>
