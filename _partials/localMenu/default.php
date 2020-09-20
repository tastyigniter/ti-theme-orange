---
description: ''
---
<div class="menu-list">

    <?php
    if ($menuIsGrouped) { ?>
        <?= partial('@grouped', ['groupedMenuItems' => $menuList]); ?>
    <?php } else { dd($menuIsGrouped); ?>
        <?= partial('@items', ['menuItems' => $menuList]); ?>
    <?php } ?> 

    <div class="pagination-bar text-right">
        <div class="links"><?= $menuList->links(); ?></div>
    </div>
</div>