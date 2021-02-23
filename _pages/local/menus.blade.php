---
title: 'main::lang.local.menus.title'
permalink: '/:location?local/menus/:category?'
description: ''
layout: local

'[localMenu]':
    isGrouped: 1
    menusPerPage: 200
    showMenuImages: 0
    menuImageWidth: 95
    menuImageHeight: 80

---
@partial('nav/local_tabs', ['activeTab' => 'menus'])

<div class="panel">
    <div class="bg-white border-bottom px-3 d-block d-lg-none">
        @partial('categories::mobile')
    </div>

    @component('localMenu')
</div>
