---
title: main::lang.account.reservations.title
layout: default
permalink: /account/reservations/:reservationId?

'[account]':
    security: customer

'[accountReservations]':
---
<div class="container">
    <div class="row py-5">
        <div class="col-sm-3">
            <?= partial('account::sidebar'); ?>
        </div>

        <div class="col-sm-9">
            <div class="card">
                <?= component('accountReservations'); ?>
            </div>
        </div>
    </div>
</div>
