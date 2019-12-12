<div class="menu-items">
    <?php if (count($menuItems)) { ?>
        <?php foreach ($menuItems as $menuItem) { ?>
            <?= partial('@item', ['menuItem' => $menuItem]); ?>
        <?php } ?>
    <?php }
    else { ?>
        <p><?= lang('igniter.local::default.text_empty'); ?></p>
    <?php } ?>
</div>
