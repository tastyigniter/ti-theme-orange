---
title: 'main::lang.locations.title'
layout: default
permalink: /locations
'[localList]':
    distanceUnit: km
    openingTimeFormat: 'ddd h:mm a'
'[categories]':
    menusPage: locations
    hideEmptyCategory: 0
description: ''
---
<div class="container-fluid py-4">
    <div class="row py-4">
        <div class="locations-filter col-sm-3 smoova-category-item">
          	<?= component('categories'); ?>
        </div>
        <div class="location-list col-sm-9">
            <div class="row">
                <div class="col-sm-4 my-2">
                    <?= partial('localBox::searchbar'); ?>
                </div>
                <div class="col-sm-4 my-2">
                    <?= partial('localList::search'); ?>
                </div>
                <div class="col-sm-4 mt-2 mb-3">
                    <?= partial('localList::filter'); ?>
                </div>
            </div>
            <?= component('localList'); ?>
        </div>
    </div>
</div>