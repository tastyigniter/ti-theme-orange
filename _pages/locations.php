---
title: main::lang.locations.title
layout: default
permalink: /locations

'[localList]':
---
<div class="container">
    <div class="row py-4">
        <div class="locations-filter col-sm-3">
            <?php if (has_component('localList')) { ?>
                <?= partial('localList::filter'); ?>
            <?php } ?>
        </div>
        <div class="location-list col-sm-9">
            <?= component('localList'); ?>
        </div>
    </div>
</div>