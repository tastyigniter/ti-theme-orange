<div class="nav flex-column">
    <a href="<?= site_url($accountPage); ?>"
       class="nav-item nav-link smoova-text-medium align-top position-relative <?= ($this->page->getId() == 'account-account') ? 'active font-weight-bold' : 'text-reset'; ?>">
        <span class="fa fa-user mr-2 align-bottom position-relative" style="font-size: 21px;"></span><?= lang('igniter.user::default.text_account'); ?></a>
    <a href="<?= site_url($addressPage); ?>"
       class="nav-item nav-link smoova-text-medium align-top position-relative <?= ($this->page->getId() == 'account-address') ? 'active font-weight-bold' : 'text-reset'; ?>">
        <span class="far fa-address-book mr-2 align-bottom position-relative" style="font-size: 21px;"></span><?= lang('igniter.user::default.text_address'); ?></a>
    <a href="<?= site_url($ordersPage); ?>"
       class="nav-item nav-link smoova-text-medium align-top position-relative <?= (in_array($this->page->getId(), ['account-order', 'account-orders'])) ? 'active font-weight-bold' : 'text-reset'; ?>">
        <span class="fas fas fa-clipboard-list mr-2 align-bottom position-relative" style="font-size: 21px;"></span><?= lang('igniter.user::default.text_orders'); ?></a>
<!--    <a-->
<!--        href="<= site_url($reservationsPage); ?>"-->
<!--        class="nav-item nav-link <= ($this->page->getId() == 'account-reservations') ? 'active font-weight-bold' : 'text-reset'; ?>"-->
<!--    ><span class="fa fa-calendar mr-3"></span><= lang('igniter.user::default.text_reservations'); ?></a>-->
</div>
