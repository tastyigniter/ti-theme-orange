---
title: main::lang.account.orders.title
layout: default
permalink: /account/order/:hash?

'[account]':

'[orderPage]':

'[localReview]':
---
<div class="container">
    <div class="row py-5">
        @if ($customer)
            <div class="col-sm-3">
                @themePartial('account/sidebar')
            </div>
        @endif

        <div class="col-sm-9{{ $customer ? '' : ' m-auto' }}">
            @componentPartial('orderPage')
        </div>
    </div>
</div>
