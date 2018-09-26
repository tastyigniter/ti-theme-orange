---
title: main::lang.checkout.title
layout: default
permalink: /checkout

'[account]':

'[localBox]':

'[cartBox]':
    pageIsCheckout: true

'[checkout]':
---
<div class="container">
    <div class="row py-4">
        <div class="col col-sm-8">
            <?= component('localBox'); ?>

            <div class="card my-1">
                <div class="card-body">
                    <?= partial('account::welcome'); ?>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <?= partial('checkout::checkout_form'); ?>
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <?= component('cartBox'); ?>
        </div>
    </div>
</div>