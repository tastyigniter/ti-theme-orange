---
title: 'main::lang.local.reviews.title'
permalink: '/:location?local/reviews'
description: ''
layout: local

'[localReview]':
    pageLimit: 10
    sort: 'date_added asc'

---
<?php
function onStart() {
    if (!setting('allow_reviews')) {
        flash()->error(lang('igniter.local::default.review.alert_review_disabled'))->now();

        return Redirect::to($controller->pageUrl($localReview->property('redirectPage')));
    }
}
?>
---
<?= partial('nav/local_tabs', ['activeTab' => 'reviews']); ?>

<div class="panel">
    <div class="panel-body">
        <h1 class="panel-title h4">
            <?php echo sprintf(lang('igniter.local::default.review.text_review_heading'), $locationCurrent->location_name); ?>
        </h1>
    </div>

    <?= component('localReview') ?>
</div>
