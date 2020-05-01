<ul class="nav navbar-nav">
    <?php foreach ($items as $navItem) { ?>
        <?php if (Auth::isLogged() AND in_array($navItem->code, ['login', 'register'])) continue; ?>
        <?php if (!Auth::isLogged() AND in_array($navItem->code, ['account', 'recent-orders'])) continue; ?>
        <li
            class="nav-item<?=
            ($navItem->items ? ' dropdown' : '').(($navItem->isActive OR $navItem->isChildActive) ? ' active' : '');
            ?>"
        >
            <a
                class="nav-link<?= ($navItem->items ? ' dropdown-toggle' : '') ?>"
                href="<?= $navItem->items ? '#' : $navItem->url; ?>"
                <?php if ($navItem->items) { ?>data-toggle="dropdown"<?php } ?>
                <?= $navItem->extraAttributes ?>
            ><?= e(lang($navItem->title)); ?><?php if ($navItem->items) { ?><span class="caret"></span><?php } ?></a>
            <?php if ($navItem->items) { ?>
                <div
                    class="dropdown-menu"
                    aria-labelledby="navbar-<?= $navItem->code ?>"
                    role="menu"
                >
                    <?php foreach ($navItem->items as $item) { ?>
                        <a
                            class="dropdown-item<?= ($item->isActive ? ' active' : '') ?>"
                            href="<?= $item->url; ?>"
                            <?= $item->extraAttributes ?>
                        ><?= e(lang($item->title)); ?></a>
                    <?php } ?>
                </div>
            <?php } ?>
        </li>
    <?php } ?>
</ul>