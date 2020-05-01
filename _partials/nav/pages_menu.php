<div class="card">
    <div class="nav flex-column">
        <?php foreach ($pagesSideMenu->menuItems() as $topItem) { ?>
            <?php foreach ($topItem->items as $item) { ?>
                <li class="nav-item">
                    <a
                        class="nav-link<?= ($item->isActive OR $item->isChildActive) ? ' active font-weight-bold' : ''; ?>"
                        href="<?= $item->url ?>"
                        <?= $item->extraAttributes ?>
                    ><?= e(lang($item->title)); ?></a>
                </li>
            <?php } ?>
        <?php } ?>
    </div>
</div>