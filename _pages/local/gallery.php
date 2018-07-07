---
title: main::lang.local.gallery.title
layout: local
permalink: /:location?local/gallery

'[localGallery]':
---
<?= partial('local/tabs', ['activeTab' => 'gallery']); ?>

<div class="panel">
    <div class="panel-body">
        <?= component('localGallery') ?>
    </div>
</div>
