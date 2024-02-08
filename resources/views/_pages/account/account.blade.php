---
title: main::lang.account.title
permalink: /account
layout: default
security: customer
---
<div class="container">
    <div class="row py-5">
        <div class="col-sm-3">
            <x-igniter-orange::nav code="account-menu" />
        </div>

        <div class="col-sm-9">
            <x-igniter-orange::account-dashboard />
            <livewire:igniter-orange::account-settings />
        </div>
    </div>
</div>
