---
title: main::default.account.orders.title
layout: default
permalink: /account/orders/:orderId?

'[account]':
    security: customer

'[accountOrders]':
---
<div class="container">
    <div class="row py-5">
        <div class="col-sm-3">
            <?= partial('account::sidebar'); ?>
        </div>

        <div class="col-sm-9">
            <div class="card">
                <?= component('accountOrders'); ?>
            </div>
        </div>
    </div>
</div>
