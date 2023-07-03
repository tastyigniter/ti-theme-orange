---
title: main::lang.locations.title
layout: default
permalink: /locations

'[localSearch]':

'[localList]':
---
<div class="container">
    <div class="row py-4">
        <div class="locations-filter col-sm-3">
            @themePartial('localList::filter')
        </div>
        <div class="location-list col-sm-9">
            @themePartial('localList::search')

            @themePartial('localList::sorting')

            @componentPartial('localList')
        </div>
    </div>
</div>
