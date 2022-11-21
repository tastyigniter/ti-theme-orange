---
title: 'main::lang.local.reviews.title'
permalink: '/:location?local/reviews'
description: ''
layout: local

'[localReview]':
    pageLimit: 10
    sort: 'created_at asc'

---
<?php
function onStart()
{
    if (!View::shared('showReviews')) {
        flash()->error(lang('igniter.local::default.review.alert_review_disabled'))->now();

        return Redirect::to($this->controller->pageUrl($this['localReview']->property('redirectPage')));
    }
}
?>
---
@partial('nav/local_tabs', ['activeTab' => 'reviews'])

<div class="panel">
    <div class="panel-body">
        <h1 class="panel-title h4">
            {{ sprintf(lang('igniter.local::default.review.text_review_heading'), $locationCurrent->location_name) }}
        </h1>
    </div>

    @component('localReview')
</div>
