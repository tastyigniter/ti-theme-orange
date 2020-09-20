---
description: ''
---
<a class="navbar-brand smoova-navbar-brand" href="<?= page_url('home'); ?>">
    <?php if ($this->theme->logo_image) { ?>
        <img
            class="img-logo smoova-logo"
            alt="<?= setting('site_name'); ?>"
            src="<?= uploads_url($this->theme->logo_image) ?>"
        >
    <?php } else if ($this->theme->logo_text) { ?>
        <span class="text-logo"><?= $this->theme->logo_text; ?></span>
    <?php } else { ?>
        <img
            class="img-logo smoova-logo"
            alt="<?= setting('site_name'); ?>"
            src="<?= uploads_url(setting('site_logo')) ?>"
        >
    <?php } ?>
</a>