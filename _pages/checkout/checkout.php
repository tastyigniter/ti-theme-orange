---
title: 'main::lang.checkout.title'
layout: default
permalink: /checkout
'[account]': null
'[cartBox]':
    cartBoxTimeFormat: 'ddd h:mm a'
    showCartItemThumb: 1
    cartItemThumbWidth: !!float 720
    cartItemThumbHeight: !!float 300
    checkStockCheckout: 1
    pageIsCheckout: 1
    pageIsCart: 0
    hideZeroOptionPrices: 1
    checkoutPage: checkout/checkout
    localBoxAlias: localBox
'[checkout]':
    showCountryField: 0
'[localList]':
    alias: '[localList]'
    distanceUnit: km
    openingTimeFormat: 'ddd h:mm a'
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
                    <?= component('checkout'); ?>
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <?= partial('cartBox/container'); ?>
        </div>
    </div>
</div>