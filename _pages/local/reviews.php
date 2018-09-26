---
title: 'main::lang.local.reviews.title'
permalink: '/:location?local/reviews'
description: ''
layout: local

'[localReview]':
    pageLimit: 10
    sort: 'date_added asc'

---
<?= partial('local/tabs', ['activeTab' => 'reviews']); ?>

<div class="panel">
    <div class="panel-body">
        <h1 class="panel-title h4">
            <?php echo sprintf(lang('igniter.local::default.text_review_heading'), $locationCurrent->location_name); ?>
        </h1>
    </div>

    <?= component('localReview') ?>
</div>
