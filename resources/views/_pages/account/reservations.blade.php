---
title: main::lang.account.reservations.title
layout: default
permalink: /account/reservations
security: customer
---
<div class="container">
    <div class="row py-5">
        <div class="col-sm-3">
            <x-igniter-orange::nav code="account-menu" />
        </div>

        <div class="col-sm-9">
            <div class="card">
                <div class="card-body">
                    <livewire:igniter-orange::list-reservations />
                </div>
            </div>
        </div>
    </div>
</div>
