---
title: main::lang.account.orders.title
layout: default
permalink: /account/order/:hash?

'[account]':

'[orderPage]':

'[localReview]':
---
<div class="container">
    <div class="row py-5">
        <?php if ($customer) { ?>
            <div class="col-sm-3">
            <?= partial('account::sidebar'); ?>
        </div>
        <?php } ?>

        <div class="col-sm-9<?= $customer ? '' : ' m-auto' ?>">
            <?= component('orderPage'); ?>
        </div>
    </div>
</div>
