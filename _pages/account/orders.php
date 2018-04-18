---
title: main::default.account.orders.title
layout: default
permalink: /account/orders/:orderId?

'[account]':
    security: customer

'[accountOrders]':
---
<div id="page-content">
    <div class="container top-spacing">
        <div class="row">
            <div class="col-sm-3 col-md-3">
                <?= partial('account::sidebar'); ?>
            </div>

            <div class="content-wrap col-sm-9 col-md-9">
                <?= component('accountOrders'); ?>
            </div>
        </div>
    </div>
</div>
