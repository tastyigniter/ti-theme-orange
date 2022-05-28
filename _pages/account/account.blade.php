---
title: main::lang.account.title
layout: account
permalink: /account

'[localBox]':

'[cartBox]':
---
<div class="container">
    <div class="row py-5">
        <div class="col-sm-3">
            @themePartial('account/sidebar')
        </div>

        <div class="col-sm-9">
            @componentPartial('account')
        </div>
    </div>
</div>
