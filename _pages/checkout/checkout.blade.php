---
title: main::lang.checkout.title
layout: default
permalink: /checkout

'[account]':

'[localBox]':
    paramFrom: location
    showLocalThumb: 0
    menusPage: local/menus

'[cartBox]':
    pageIsCheckout: true

'[checkout]':
    showCountryField: 0
---
<div class="container">
    <div class="row py-4">
        <div class="col col-lg-8">
            @partial('localBox::container')

            <div class="card my-1">
                <div class="card-body">
                    @partial('account/welcome')
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    @component('checkout')
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            @partial('cartBox::container')
        </div>
    </div>
</div>