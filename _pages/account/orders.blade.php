---
title: main::lang.account.orders.title
layout: account
permalink: /account/orders

'[accountOrders]':
---
<div class="container">
    <div class="row py-5">
        <div class="col-sm-3">
            @themePartial('account/sidebar')
        </div>

        <div class="col-sm-9">
            <div class="card">
                <div class="card-body">
                    @componentPartial('accountOrders')
                </div>
            </div>
        </div>
    </div>
</div>
