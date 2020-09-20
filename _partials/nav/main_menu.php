---
description: ''
---
<ul class="nav navbar-nav smoova-nav-width">
    <?php foreach ($items as $navItem) { ?>
        <?php if (Auth::isLogged() and in_array($navItem->code, ['login', 'register'])) continue; ?>
        <?php if (!Auth::isLogged() and in_array($navItem->code, ['account', 'recent-orders'])) continue; ?>
        <li
                class="nav-item<?=
                ($navItem->items ? ' dropdown' : '') . (($navItem->isActive or $navItem->isChildActive) ? ' active' : '');
                ?>"
        >

            <a class="nav-link<?= ($navItem->items ? ' dropdown-toggle' : '') ?> smoova-text-medium smoova-account-menu"
               href="<?= $navItem->items ? '#' : $navItem->url; ?>"
               <?php if ($navItem->items) { ?>data-toggle="dropdown"<?php } ?>

            ><?= $navItem->extraAttributes ?>
                <?php if ($customer) { ?>
                    <?= $customer->first_name ?>
                <?php } else { ?>
                    <?= e(lang($navItem->title)); ?>
                <?php } ?>

                <?php if ($navItem->items) { ?>
                    <span class="caret"></span>
                <?php } ?></a>
            <?php if ($navItem->items) { ?>
                <div
                        class="dropdown-menu"
                        aria-labelledby="navbar-<?= $navItem->code ?>"
                        role="menu"
                >
                    <?php foreach ($navItem->items as $item) { ?>
                        <a
                                class="dropdown-item<?= ($item->isActive ? ' active' : '') ?> smoova-text-medium"
                                href="<?= $item->url; ?>"
                            <?= $item->extraAttributes ?>
                        ><?= e(lang($item->title)); ?></a>
                    <?php } ?>
                </div>
            <?php } ?>
        </li>

    <?php }
    if (Auth::isLogged()) { ?>
        <a href="/checkout"><span class="fa fa-shopping-basket ml-3 mt-3" style="font-size: 22px;"></span></a>
    <?php } else { ?>
        <a href="/checkout"><span class="fa fa-shopping-basket ml-4 mt-3" style="font-size: 22px;"></span></a>
    <?php } ?>
</ul>
