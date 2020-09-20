---
description: ''
---
<!--<div class="menu-items">-->
<div class="card-deck mx-0">
    <?php if (count($menuItems)) { ?>
        <?php foreach ($menuItems as $menuItem) { ?>
            <?= partial('@item_card', ['menuItem' => $menuItem]); ?>
        <?php } ?>
    <?php }
    else { ?>
        <p><?= lang('igniter.local::default.text_empty'); ?></p>
    <?php } ?>
</div>