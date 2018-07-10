---
title: main::lang.checkout.title
layout: default
permalink: /checkout

'[account]':

'[local]':

'[cartBox]':
    pageIsCheckout: true

'[checkout]':
---
<div class="container">
    <div class="row py-4">
        <div class="col col-sm-8">
            <?= component('local'); ?>

            <div class="card my-1">
                <div class="card-body">
                    <?php if (has_component('account')) { ?>
                        <?= partial('account::welcome'); ?>
                    <?php } ?>
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