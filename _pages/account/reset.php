---
title: main::default.account.reset.title
layout: default
permalink: /forgot-password/:code?

'[account]':
    security: guest

'[resetPassword]':
---
<div id="page-content">
    <div class="container">
        <div class="heading-section">
            <h3><?= lang('main::default.account.reset.text_heading'); ?></h3>
        </div>

        <div class="row">
            <div class="content-wrap col-md-6 center-block">
                <?= component('resetPassword'); ?>
            </div>
        </div>
    </div>
</div>