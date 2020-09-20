---
title: 'main::lang.home.title'
permalink: /
description: ''
layout: default
'[localList]':
    distanceUnit: km
    openingTimeFormat: 'ddd h:mm a'
'[categories]':
    menusPage: home
    hideEmptyCategory: 0
---
<div class="container-fluid py-4">
    <div class="row">
        <div class="locations-filter col-sm-2  smoova-category-fixed">
            <form role="form"
                  id="locationListForm"
                  method="POST"
                  accept-charset="utf-8"
                  action="<?= current_url(); ?>">
                <?= csrf_field(); ?>
                <div class="mt-3">
                    <?= component('categories'); ?>
                    <?= partial('localList::filter'); ?>
                </div>
        </div>
        <div class="location-list col-sm-10 smoova-store-list">
            <?= component('localList'); ?>
        </div>
    </div>
</div>