---
title: main::lang.local.gallery.title
layout: local
permalink: /:location?local/gallery

'[localGallery]':
---
@themePartial('nav/local_tabs', ['activeTab' => 'gallery'])

<div class="panel">
    <div class="panel-body">
        @componentPartial('localGallery')
    </div>
</div>
