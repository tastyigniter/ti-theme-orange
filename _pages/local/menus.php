---
title: 'main::lang.local.menus.title'
permalink: '/:location?local/menus/:category?'
description: ''
layout: local
'[localMenu]':
    isGrouped: 1
    menusPerPage: !!float 2000
    showMenuImages: 1
    menuImageWidth: !!float 350
    menuImageHeight: !!float 240
    defaultLocationParam: local
    localNotFoundPage: home
---
<?= partial('nav/local_tabs', ['activeTab' => 'menus']); ?>

<div class="panel">
    <div class="d-block d-sm-none">
        <div class="panel-body categories">
            <?= component('categories'); ?>
        </div>
    </div>

    <?= component('localMenu') ?>
</div>