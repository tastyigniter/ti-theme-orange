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
<?= partial('local/tabs', ['activeTab' => 'menus']); ?>

<div class="panel">
    <div class="d-block d-sm-none">
        <div class="categories">
            <?= component('categories'); ?>
        </div>
    </div>

    <div class="panel-body">
        <?= component('localMenu') ?>
    </div>
</div>