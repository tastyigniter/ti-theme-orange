---
title: main::default.account.settings.title
layout: default
permalink: /account/settings

'[account]':
    security: customer
---
<div class="container">
    <div class="row py-5">
        <div class="col-sm-3">
            <?= partial('account::sidebar'); ?>
        </div>

        <div class="col-sm-9">
            <div class="card">
                <div class="card-body">
                    <?= partial('account::settings'); ?>
                </div>
            </div>
        </div>
    </div>
</div>
