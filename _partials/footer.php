<div class="main-footer pt-sm-3">
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <div class="footer-links">
                    <h6 class="footer-title d-none d-sm-block"><?= lang('main::default.text_my_account'); ?></h6>
                    <ul>
                        <li>
                            <a href="<?= site_url('account/login'); ?>">
                                <?= lang('main::default.menu_login'); ?>
                            </a>
                        </li>
                        <li>
                            <a href="<?= site_url('account/register'); ?>">
                                <?= lang('main::default.menu_register'); ?>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="footer-links">
                    <h6 class="footer-title d-none d-sm-block"><?= setting('site_name'); ?></h6>
                    <ul>
                        <?php if (!is_single_location()) { ?>
                            <li>
                                <a href="<?= site_url('locations'); ?>">
                                    <?= lang('main::default.menu_locations'); ?>
                                </a>
                            </li>
                        <?php } ?>
                        <li>
                            <a href="<?= site_url('contact'); ?>">
                                <?= lang('main::default.menu_contact'); ?>
                            </a>
                        </li>
                        <?php if ($this->theme->hide_admin_link != 1) { ?>
                            <li>
                                <a
                                    target="_blank"
                                    href="<?= admin_url(); ?>"
                                >
                                    <?= lang('main::default.menu_admin'); ?>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="footer-links">
                    <h6 class="footer-title d-none d-sm-block"><?= lang('main::default.text_information'); ?></h6>
                    <ul>
                        <?php if (!empty($footerPageList)) foreach ($footerPageList as $page) { ?>
                            <li>
                                <a
                                    href="<?= page_url('pages', ['slug' => $page->permalink_slug]); ?>"
                                >
                                    <?= $page->name; ?>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>

            <div class="col-sm-3 mt-3 mt-sm-0">
                <div class="social-bottom">
                    <h6 class="footer-title"><?= lang('main::default.text_follow_us'); ?></h6>
                    <?= partial('social_icons', ['socialIcons' => $this->theme->social]); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col">
            <hr class="mb-3">
        </div>
    </div>
</div>

<div class="bottom-footer py-2">
    <div class="container">
        <div class="row">
            <div class="col p-2">
                <?= sprintf(
                    lang('main::default.site_copyright'),
                    date('Y'),
                    setting('site_name'),
                    lang('system::default.tastyigniter.system_name')
                ).lang('system::default.tastyigniter.system_powered'); ?>
            </div>
        </div>
    </div>
</div>
