---
title: igniter.orange::default.account_address_title
layout: default
permalink: /account/address/:addressId?
security: customer

'[igniter-orange::address-book]': []
---
<div class="container">
    <div class="row py-5">
        <div class="col-sm-3">
            <x-igniter-orange::nav code="account-menu" />
        </div>

        <div class="col-sm-9">
            <livewire:igniter-orange::address-book />
        </div>
    </div>
</div>
