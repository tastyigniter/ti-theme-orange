---
title: igniter.orange::default.account_reservation_title
layout: default
permalink: /account/reservation/:hash

'[igniter-orange::reservation-preview]': []
'[igniter-orange::leave-review]':
    type: reservation
---
<div class="container">
    <div class="row py-5">
        <div class="col-sm-3">
            <x-igniter-orange::nav code="account-menu" />
        </div>

        <div class="col-sm-9">
            <livewire:igniter-orange::reservation-preview />

            <livewire:igniter-orange::leave-review />
        </div>
    </div>
</div>
