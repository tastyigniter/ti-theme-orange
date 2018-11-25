<meta name="description" content="<?= setting('meta_description') ?>">
<meta name="keywords" content="<?= setting('meta_keywords') ?>">
<?= get_metas(); ?>
<?php if (trim($favicon = $this->theme->favicon, '/')) { ?>
    <link href="<?= uploads_url($favicon); ?>" rel="shortcut icon" type="image/ico">
<?php }
else { ?>
    <?= get_favicon(); ?>
<?php } ?>
<title><?= sprintf(lang('main::lang.site_title'), lang(get_title()), setting('site_name')); ?></title>
<?= get_style_tags(); ?>
<?php if (!empty($this->theme->custom_css)) { ?>
    <?= '<link type="text/css" id="custom-css">'.$this->theme->custom_css.'</link>' ?>
<?php } ?>