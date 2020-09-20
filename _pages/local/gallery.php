---
title: 'main::lang.local.gallery.title'
layout: local
permalink: '/:location?local/gallery'
'[localGallery]': null
'[slider]':
    code: home-slider
    height: 800
    effect: ease
    delayInterval: !!float 5000
    hideControls: 0
    hideIndicators: 0
    hideCaptions: 0
description: ''
---
<?= partial('nav/local_tabs', ['activeTab' => 'gallery']); ?>

<div class="panel">
    <div class="panel-body">
        <?= component('localGallery') ?>

      <?= component('slider') ?>

    </div>
</div>