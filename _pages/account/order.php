---
title: 'main::lang.account.orders.title'
layout: default
permalink: '/account/order/:hash?'
'[account]': null
'[orderPage]': null
description: ''
'[localReview]':
    alias: '[localReview]'
    pageLimit: 20
    sort: 'date_added asc'
    reviewDateFormat: 'DD MMM YY'
    reviewableType: order
    reviewableHash: '{{ :hash }}'
    redirectPage: local/menus
---
<div class="container-fluid">
    <div class="row py-5">
        <?php if ($customer) { ?>
            <div class="col-sm-2">
            <?= partial('account::sidebar'); ?>
        </div>
        <?php } ?>

        <div class="col-sm-10<?= $customer ? '' : ' m-auto' ?>">
            <?= component('orderPage'); ?>
        </div>
    </div>
</div>