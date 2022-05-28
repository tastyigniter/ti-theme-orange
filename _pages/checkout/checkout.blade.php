---
title: main::lang.checkout.title
layout: default
permalink: /checkout

'[account]':

'[localSearch]':
    hideSearch: 1

'[localBox]':
    paramFrom: location
    showLocalThumb: 0

'[cartBox]':
    pageIsCheckout: true

'[checkout]':
    showCountryField: 0
---
<div class="container">
    <div class="row py-4">
        <div class="col col-lg-8">
            @themePartial('localBox::container')

            <div class="card my-1">
                <div class="card-body">
                    @themePartial('account/welcome')
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    @componentPartial('checkout')
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            @themePartial('cartBox::container')
        </div>
    </div>
</div>
