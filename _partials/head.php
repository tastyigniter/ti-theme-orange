<?= get_metas(); ?>
<meta name="csrf-token" content="<?= csrf_token() ?>">
<?php if (trim($favicon = $this->theme->favicon, '/')) { ?>
    <link href="<?= uploads_url($favicon); ?>" rel="shortcut icon" type="image/ico">
<?php }
else { ?>
    <?= get_favicon(); ?>
<?php } ?>
<title><?= sprintf(lang('main::lang.site_title'), lang(get_title()), setting('site_name')); ?></title>
<link href="//fonts.googleapis.com/css?family=Amaranth|Titillium+Web:200,200i,400,400i,600,600i,700,700i|Droid+Sans+Mono" rel="stylesheet">
<?= get_style_tags(); ?>
<?php if (!empty($this->theme->custom_css)) { ?>
    <style type="text/css" id="custom-css"><?= $this->theme->custom_css; ?></style>
<?php } ?>