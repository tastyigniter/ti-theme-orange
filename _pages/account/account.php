---
title: main::lang.account.title
layout: default
permalink: /account

'[account]':
    security: customer

'[local]':

'[cartBox]':
---
<div class="container">
    <div class="row py-5">
        <div class="col-sm-3">
            <?= partial('account::sidebar'); ?>
        </div>

        <div class="col-sm-9">
            <?= component('account'); ?>
        </div>
    </div>
</div>
