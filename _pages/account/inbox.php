---
title: main::lang.account.inbox.title
layout: default
permalink: /account/inbox

'[account]':
    security: customer

'[accountInbox]':
---
<div class="container">
    <div class="row py-5">
        <div class="col-sm-3 col-md-3">
            <?= partial('account::sidebar'); ?>
        </div>

        <div class="content-wrap col-sm-9 col-md-9">
            <div class="card">
                <?= component('accountInbox'); ?>
            </div>
        </div>
    </div>
</div>
