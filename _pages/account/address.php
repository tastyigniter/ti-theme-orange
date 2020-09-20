---
title: 'main::lang.account.address.title'
layout: account
permalink: '/account/address/:addressId?'
'[accountAddressBook]': null
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
                    <?= component('accountAddressBook'); ?>
                </div>
            </div>
        </div>
    </div>
</div>