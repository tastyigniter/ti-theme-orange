---
description: ''
---
<?= get_metas(); ?>
<meta name="csrf-token" content="<?= csrf_token() ?>">
<!--<script async src="https://www.googletagmanager.com/gtag/js?id=G-4459SWSTHD"></script>-->
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-4459SWSTHD"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-4459SWSTHD');
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=<?= setting('maps_api_key'); ?>&language=<?= setting('default_language'); ?>&region=AU&libraries=places"></script>
<script async src="https://www.googletagmanager.com/gtag/js?id=G-4459SWSTHD"></script>
<!--
<script src="https://maps.googleapis.com/maps/api/js?location=25.2744, 133.7751&libraries=places&key=AIzaSyDaCODPfbEJq7MJ3mCxka8yts0SDHUTv-8&libraries=places&callback=initAutocomplete" async defer></script>
-->
<script src="/themes/tastyigniter-orange-ddv/assets/js/smoova.js"></script>
<link rel="stylesheet" href="/themes/tastyigniter-orange-ddv/assets/css/smoova.css">

<?php if (trim($favicon = $this->theme->favicon, '/')) { ?>
    <link href="<?= uploads_url($favicon); ?>" rel="shortcut icon" type="image/ico">
<?php }
else { ?>
    <?= get_favicon(); ?>
<?php } ?>
<title><?= sprintf(lang('main::lang.site_title'), lang(get_title()), setting('site_name')); ?></title>
<?= get_style_tags(); ?>
<?php if (!empty($this->theme->custom_css)) { ?>
    <style type="text/css" id="custom-css"><?= $this->theme->custom_css; ?></style>
<?php } ?>