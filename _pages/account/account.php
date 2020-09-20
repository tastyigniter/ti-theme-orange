---
title: 'main::lang.account.title'
layout: account
permalink: /account
'[cartBox]':
    cartBoxTimeFormat: 'ddd h:mm a'
    showCartItemThumb: 0
    cartItemThumbWidth: !!float 720
    cartItemThumbHeight: !!float 300
    checkStockCheckout: 1
    pageIsCheckout: 0
    pageIsCart: 0
    hideZeroOptionPrices: 1
    checkoutPage: checkout/checkout
    localBoxAlias: localBox
description: ''
---
<div class="container-fluid">
    <div class="row py-5">
        <div class="col-sm-2">
            <?= partial('account::sidebar'); ?>
        </div>

        <div class="col-sm-10">
            <?= component('account'); ?>
        </div>
    </div>
</div>