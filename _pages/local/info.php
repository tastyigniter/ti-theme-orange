---
title: main::default.local.info.title
layout: local
permalink: /:location?local/info

'[localInfo]':
---
<?= partial('local/tabs', ['activeTab' => 'info']); ?>

<?= component('localInfo') ?>
