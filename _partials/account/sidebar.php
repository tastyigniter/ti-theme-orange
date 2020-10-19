<div class="nav flex-column">
    <a
        href="<?= site_url($accountPage); ?>"
        class="nav-item nav-link <?= ($this->page->getId() == 'account-account') ? 'active font-weight-bold' : 'text-reset'; ?>"
    ><span class="fa fa-user mr-3"></span><?= lang('igniter.user::default.text_account'); ?></a>
    <a
        href="<?= site_url($addressPage); ?>"
        class="nav-item nav-link <?= ($this->page->getId() == 'account-address') ? 'active font-weight-bold' : 'text-reset'; ?>"
    ><span class="fa fa-book mr-3"></span><?= lang('igniter.user::default.text_address'); ?></a>
    <a
        href="<?= site_url($ordersPage); ?>"
        class="nav-item nav-link <?= (in_array($this->page->getId(), ['account-order', 'account-orders'])) ? 'active font-weight-bold' : 'text-reset'; ?>"
    ><span class="fa fa-list-alt mr-3"></span><?= lang('igniter.user::default.text_orders'); ?></a>
    <a
        href="<?= site_url($reservationsPage); ?>"
        class="nav-item nav-link <?= ($this->page->getId() == 'account-reservations') ? 'active font-weight-bold' : 'text-reset'; ?>"
    ><span class="fa fa-calendar mr-3"></span><?= lang('igniter.user::default.text_reservations'); ?></a>
</div>
