---
title: main::lang.account.orders.title
layout: default
permalink: /account/orders
security: customer
---
<div class="container">
    <div class="row py-5">
        <div class="col-sm-3">
            <x-igniter-orange::nav code="account-menu"/>
        </div>

        <div class="col-sm-9">
            <div class="card">
                <div class="card-body">
                    <x-igniter-orange::list-orders/>
                </div>
            </div>
        </div>
    </div>
</div>
