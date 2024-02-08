---
title: main::lang.account.address.title
layout: default
permalink: /account/address/:addressId?
security: customer
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
