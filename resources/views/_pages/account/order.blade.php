---
title: igniter.orange::default.account_order_title
layout: default
permalink: /account/order/:hash
security: all

'[igniter-orange::order-preview]': []
'[igniter-orange::leave-review]':
    type: order
---
<div class="container">
    <div class="row py-4">
        <div class="col-sm-3">
            <x-igniter-orange::nav code="account-menu"/>
        </div>

        <div class="col-sm-9">
            <livewire:igniter-orange::order-preview/>
        </div>
    </div>
</div>
