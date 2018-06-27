<a class="navbar-brand" href="<?= page_url('home'); ?>">
    <?php if ($this->theme->logo_image) { ?>
        <img
            class="img-logo"
            alt="<?= setting('site_name'); ?>"
            src="<?= image_url($this->theme->logo_image) ?>"
        >
    <?php } else if ($this->theme->logo_text) { ?>
        <span class="text-logo"><?= $this->theme->logo_text; ?></span>
    <?php } else if (str_contains(setting('site_logo'), 'no_photo')) { ?>
        <span class="text-logo"><?= setting('site_name'); ?></span>
    <?php } else { ?>
        <img
            class="img-logo"
            alt="<?= setting('site_name'); ?>"
            src="<?= image_url(setting('site_logo')) ?>"
        >
    <?php } ?>
</a>
