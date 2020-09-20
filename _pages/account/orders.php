---
title: 'main::lang.account.orders.title'
layout: account
permalink: '/account/orders/:orderId?'
'[accountOrders]': null
description: ''
'[localReview]':
    pageLimit: !!float 20
    sort: 'date_added asc'
    reviewDateFormat: 'DD MMM YY'
    reviewableType: order
    reviewableHash: '{{ :hash }}'
---
<div class="container-fluid">
    <div class="row py-5">
        <div class="col-sm-2">
            <?= partial('account::sidebar'); ?>
        </div>

        <div class="col-sm-10">
            <div class="card">
                <div class="card-body">
                    <?= component('accountOrders'); ?>
                </div>
            </div>
        </div>
    </div>
</div>