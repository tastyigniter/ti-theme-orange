---
title: main::lang.account.reviews.title
layout: account
permalink: /account/reviews/:saleType?/:saleId?

'[accountReviews]':
---
<div class="container">
    <div class="row py-5">
        <div class="col-sm-3">
            <?= partial('account::sidebar'); ?>
        </div>

        <div class="col-sm-9">
            <div class="card">
                <?= component('accountReviews'); ?>
            </div>
        </div>
    </div>
</div>
