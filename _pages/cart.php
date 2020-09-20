---
title: 'main::lang.cart.title'
layout: default
permalink: /cart
'[cartBox]':
    cartBoxTimeFormat: 'ddd h:mm a'
    showCartItemThumb: 0
    cartItemThumbWidth: !!float 720
    cartItemThumbHeight: !!float 300
    checkStockCheckout: 1
    pageIsCheckout: 0
    pageIsCart: 1
    hideZeroOptionPrices: 1
    checkoutPage: checkout/checkout
    localBoxAlias: localBox
'[localList]':
    distanceUnit: km
    openingTimeFormat: 'ddd h:mm a'
description: ''
---
<div class="container">
    <div class="row py-4">
        <div class="col col-sm-6 m-auto">
            <div class="cart-buttons">
                <a
                    class="btn btn-link btn-block btn-md"
                    href="<?= restaurant_url('local/menus'); ?>"
                >Add more items</a>
            </div>

            <?= partial('cartBox/container'); ?>
        </div>
    </div>
</div>