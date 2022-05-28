---
title: main::lang.account.reservations.title
layout: account
permalink: /account/reservations/:hash?

'[accountReservations]':

'[localReview]':
    reviewableType: reservation
---
<div class="container">
    <div class="row py-5">
        <div class="col-sm-3">
            @themePartial('account/sidebar')
        </div>

        <div class="col-sm-9">
            <div class="card">
                <div class="card-body">
                    @componentPartial('accountReservations')
                </div>
            </div>
        </div>
    </div>
</div>
