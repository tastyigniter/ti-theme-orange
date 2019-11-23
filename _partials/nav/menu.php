<nav class="navbar navbar-light navbar-top navbar-expand-md fixed-top">
    <div class="container">
        <?= partial('nav/logo'); ?>
        <button
            class="navbar-toggler border-0"
            type="button"
            data-toggle="collapse"
            data-target="#navbarMainHeader"
            aria-controls="navbarMainHeader"
            aria-expanded="false"
            aria-label="Toggle navigation"
        ><span class="navbar-toggler-icon"></span></button>

        <div class="justify-content-end collapse navbar-collapse" id="navbarMainHeader">
            <ul class="nav navbar-nav">
                <li class="nav-item">
                    <a
                        class="nav-link"
                        href="<?= restaurant_url('local/menus'); ?>"
                        class="<?= ($this->page->getId() == 'local-menus') ? 'active' : ''; ?>"
                    ><?= lang('main::lang.menu_menu'); ?></a>
                </li>

                <li class="nav-item">
                    <a
                        class="nav-link"
                        href="<?= page_url('reservation/reservation'); ?>"
                        class="<?= ($this->page->getId() == 'reservation-reservation') ? 'active' : ''; ?>"
                    ><?= lang('main::lang.menu_reservation'); ?></a>
                </li>

                <?php if (Auth::isLogged()) { ?>
                    <li class="nav-item dropdown">
                        <a
                            id="dropdownAccount"
                            class="nav-link dropdown-toggle clickable"
                            role="button"
                            href="#"
                            data-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false"
                        ><?= lang('main::lang.menu_my_account'); ?> <span class="caret"></span></a>

                        <div
                            class="dropdown-menu"
                            role="menu"
                            aria-labelledby="dropdownAccount"
                        >
                            <a
                                href="<?= page_url('account/orders'); ?>"
                                class="dropdown-item <?= ($this->page->getId() == 'account-orders') ? 'active' : ''; ?>"
                            ><?= lang('main::lang.menu_recent_order'); ?></a>
                            <a
                                href="<?= page_url('account/account'); ?>"
                                class="dropdown-item <?= ($this->page->getId() == 'account-account') ? 'active' : ''; ?>"
                            ><?= lang('main::lang.menu_my_account'); ?></a>
                            <a
                                href="<?= page_url('account/address'); ?>"
                                class="dropdown-item <?= ($this->page->getId() == 'account-address') ? 'active' : ''; ?>"
                            ><?= lang('main::lang.menu_address'); ?></a>

                            <a
                                href="<?= page_url('account/reservations'); ?>"
                                class="dropdown-item <?= ($this->page->getId() == 'account-reservations') ? 'active' : ''; ?>"
                            ><?= lang('main::lang.menu_recent_reservation'); ?></a>

                            <a
                                href="javascript:;"
                                class="dropdown-item"
                                data-request="session::onLogout"
                            ><?= lang('main::lang.menu_logout'); ?></a>
                        </div>
                    </li>
                <?php } else { ?>
                    <li class="nav-item">
                        <a
                            href="<?= page_url('account/login'); ?>"
                            class="nav-link <?= ($this->page->getId() == 'account-login') ? 'active' : ''; ?>"
                        ><?= lang('main::lang.menu_login'); ?></a>
                    </li>
                    <?php if ((bool)setting('allow_registration', true)) { ?>
                        <li class="nav-item">
                            <a
                                href="<?= page_url('account/register'); ?>"
                                class="nav-link <?= ($this->page->getId() == 'account-register') ? 'active' : ''; ?>"
                            ><?= lang('main::lang.menu_register'); ?></a>
                        </li>
                    <?php } ?>
                <?php } ?>

                <?php if (!empty($headerPageList)) foreach ($headerPageList as $page) { ?>
                    <li class="nav-item">
                        <a class="nav-link"
                           href="<?= page_url('pages', ['slug' => $page->permalink_slug]); ?>"
                        ><?= $page->name; ?></a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</nav>