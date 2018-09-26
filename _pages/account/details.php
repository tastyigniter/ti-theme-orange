---
title: main::lang.account.settings.title
layout: account
permalink: /account/settings

'[account]':
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
