---
title: main::lang.local.info.title
layout: local
permalink: /:location?local/info

'[localInfo]':
---
<?= partial('nav/local_tabs', ['activeTab' => 'info']); ?>

<?= component('localInfo') ?>
