---
description: ''
---
<div class="footer pt-5 pb-5">
    <div class="container-fluid">
        <div class="row smoova-mobile-footer">
          <div class="col-sm-2 mt-3 mt-sm-0"></div>
            <?php foreach ($footerMenu->menuItems() as $navItem) { ?>
                <div class="col-sm-2 smoova-mobile-col-sm">
                    <div class="footer-links">
                        <h6 class="footer-title d-none d-sm-block"><?= lang($navItem->title); ?></h6>
                        <ul>
                            <?php foreach ($navItem->items as $item) { ?>
                                <li>
                                    <a
                                        href="<?= $item->url; ?>"
                                        <?= $item->extraAttributes ?>
                                    ><?= e(lang($item->title)); ?></a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            <?php } ?>

            <div class="col-sm-2 mt-3 mt-sm-0  text-center">
                <div class="social-bottom text-center">
                    <h6 class="footer-title  text-center"><?= lang('main::lang.text_follow_us'); ?></h6>
                    <?= partial('social_icons', ['socialIcons' => $this->theme->social]); ?>
                </div>
            </div>

            <div class="col-sm-2 mt-3 mt-sm-0"></div>
          
            <?php if (has_component('!newsletter')) { ?>
                <div class="col-sm-2 mt-3 mt-sm-0">
                    <div id="newsletter-box">
                        <h5 class="mb-4"><?= lang('igniter.frontend::default.newsletter.text_subscribe'); ?></h5>
                        <?= partial('newsletter::subscribe-form'); ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <hr class="mb-3">
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 text-center">
                <?= sprintf(
                    lang('main::lang.site_copyright'),
                    date('Y'),
                    setting('site_name'),
                    lang('system::lang.system_name')
                ).lang('system::lang.system_powered'); ?>
            </div>
        </div>
    </div>
</div>