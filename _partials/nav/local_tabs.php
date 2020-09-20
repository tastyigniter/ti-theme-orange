---
description: ''
---
<ul id="nav-tabs" class="nav-menus nav nav-tabs">
    <a class="nav-item nav-link <?= ($activeTab === 'menus') ? 'active' : ''; ?>"
       href="<?= restaurant_url('local/menus'); ?>"
    ><?= lang('main::lang.local.text_tab_menu'); ?></a>

    <a class="nav-item nav-link <?= ($activeTab === 'info') ? 'active' : ''; ?>"
       href="<?= restaurant_url('local/info'); ?>"
    ><?= lang('main::lang.local.text_tab_info'); ?></a>

    <?php if (setting('allow_reviews', 1)) { ?>
        <a class="nav-item nav-link <?= ($activeTab === 'reviews') ? 'active' : ''; ?>"
           href="<?= restaurant_url('local/reviews'); ?>"
        ><?= lang('main::lang.local.text_tab_review'); ?></a>
    <?php } ?>

    <?php if (isset($locationCurrent) and $locationCurrent->hasGallery()) { ?>
        <a class="nav-item nav-link <?= ($activeTab === 'gallery') ? 'active' : ''; ?>"
           href="<?= restaurant_url('local/gallery'); ?>"
        ><?= lang('main::lang.local.text_tab_gallery'); ?></a>
    <?php } ?>
<!--	--><?php //if (isset($locationCurrent) and $locationCurrent->hasGallery()) { ?>
<!--        <a class="nav-item nav-link"  --><?//= ($activeTab === 'reservation') ? 'active' : ''; ?><!--"-->
<!--           href="--><?//= restaurant_url('reservation/reservation'); ?><!--"-->
<!--        >--><?//= lang('admin::lang.reservations.text_tab_general'); ?><!--</a>-->
<!--	--><?php //} ?>
</ul>