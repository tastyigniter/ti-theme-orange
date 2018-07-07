---
title: main::lang.local.info.title
layout: local
permalink: /:location?local/info

'[localInfo]':
---
<?= partial('local/tabs', ['activeTab' => 'info']); ?>

<?= component('localInfo') ?>
