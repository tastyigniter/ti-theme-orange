---
title: main::lang.local.gallery.title
layout: local
permalink: /:location?local/gallery

'[localGallery]':
---
<?= partial('nav/local_tabs', ['activeTab' => 'gallery']); ?>

<div class="panel">
    <div class="panel-body">
        <?= component('localGallery') ?>
    </div>
</div>
