<div class="nav flex-column">
    <a
        href="{{ page_url('account/account') }}"
        class="nav-item nav-link fw-medium {{ ($activePage == 'account-account') ? 'active' : 'text-reset' }}"
    ><span class="fa fa-user text-muted me-3"></span>@lang('igniter.user::default.text_account')</a>
    <a
        href="{{ page_url('account/address') }}"
        class="nav-item nav-link fw-medium {{ ($activePage == 'account-address') ? 'active' : 'text-reset' }}"
    ><span class="fa fa-book text-muted me-3"></span>@lang('igniter.user::default.text_address')</a>
    <a
        href="{{ page_url('account/orders') }}"
        class="nav-item nav-link fw-medium {{ (in_array($activePage, ['account-order', 'account-orders'])) ? 'active' : 'text-reset' }}"
    ><span class="fa fa-list-alt text-muted me-3"></span>@lang('igniter.user::default.text_orders')</a>
    <a
        href="{{ page_url('account/reservations') }}"
        class="nav-item nav-link fw-medium {{ ($activePage == 'account-reservations') ? 'active' : 'text-reset' }}"
    ><span class="fa fa-calendar text-muted me-3"></span>@lang('igniter.user::default.text_reservations')</a>
</div>
