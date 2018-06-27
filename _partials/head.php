<meta name="description" content="<?= setting('meta_description') ?>">
<meta name="keywords" content="<?= setting('meta_keywords') ?>">
<?= get_metas(); ?>
<?php if (trim($favicon = $this->theme->favicon, '/')) { ?>
    <link href="<?= image_url($favicon); ?>" rel="shortcut icon" type="image/ico">
<?php }
else { ?>
    <?= get_favicon(); ?>
<?php } ?>
<title><?= sprintf(lang('main::default.site_title'), lang(get_title()), setting('site_name')); ?></title>
<?= get_style_tags(['ui', 'widget', 'component', 'theme', 'custom']); // Render link tags added by widget, components. ?>
<?php if (empty($this->theme->custom_css)) { ?>
    <?= '<link type="text/css" id="custom-css">'.$this->theme->custom_css.'</link>' ?>
<?php } ?>