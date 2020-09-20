---
title: 'main::lang.checkout.success.title'
layout: default
permalink: '/checkout/success/:hash?'
'[orderPage]':
    orderDateTimeFormat: 'DD MMM \a\t h:mm a'
    hideReorderBtn: 1
    hashParamName: hash
'[localReview]': null
---
<div class="container">
    <div class="row py-4">
        <div class="col-sm-9 m-auto">
            <?= component('orderPage'); ?>
        </div>
    </div>
</div>