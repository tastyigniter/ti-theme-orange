---
title: main::lang.reservation.title
layout: default
permalink: /reservation

'[account]':

'[booking]':
---
<div class="container">
    <div class="row py-4">
        <div class="col col-sm-10 center-block">
            <div class="card mb-1">
                <div class="card-body">
                    <?= partial('account::welcome'); ?>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <?= component('booking'); ?>
                </div>
            </div>
        </div>
    </div>
</div>
