---
title: 'main::lang.account.reservations.title'
layout: account
permalink: '/account/reservations/:hash?'
'[accountReservations]': null
'[localReview]':
    reviewableType: reservation
description: ''
---
<div class="container-fluid">
    <div class="row py-5">
        <div class="col-sm-2">
            <?= partial('account::sidebar'); ?>
        </div>

        <div class="col-sm-10">
            <div class="card">
                <div class="card-body">
                    <?= component('accountReservations'); ?>
                </div>
            </div>
        </div>
    </div>
</div>