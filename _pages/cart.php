---
title: main::lang.cart.title
layout: default
permalink: /cart

'[localBox]':

'[cartBox]':
    pageIsCart: 1
---
<div class="container">
    <div class="row py-4">
        <div class="col col-sm-6 m-auto">
            <div class="cart-buttons wrap-bottom">
                <a
                    class="btn btn-default btn-block btn-md"
                    href="<?= restaurant_url('local/menus'); ?>"
                >Add more items</a>
            </div>

            <?= component('cartBox'); ?>
        </div>
    </div>
</div>
