---
title: main::lang.checkout.success.title
layout: default
permalink: /checkout/success/:hash?

'[orderPage]':
    hideReorderBtn: 1

'[localReview]':
---
<div class="container">
    <div class="row py-4">
        <div class="col-sm-9 m-auto">
            <?= component('orderPage'); ?>
        </div>
    </div>
</div>