<div class="nav flex-column">
    <a
        href="{{ page_url('account/account') }}"
        wire:navigate
        class="nav-item nav-link fw-bold {{ ($activePage == 'account-account') ? 'active' : 'text-reset' }}"
    ><span class="fa fa-user me-3"></span>@lang('igniter.user::default.text_account')</a>
    <a
        href="{{ page_url('account/address') }}"
        wire:navigate
        class="nav-item nav-link fw-bold {{ ($activePage == 'account-address') ? 'active' : 'text-reset' }}"
    ><span class="fa fa-book me-3"></span>@lang('igniter.user::default.text_address')</a>
    <a
        href="{{ page_url('account/orders') }}"
        wire:navigate
        class="nav-item nav-link fw-bold {{ (in_array($activePage, ['account-order', 'account-orders'])) ? 'active' : 'text-reset' }}"
    ><span class="fa fa-list-alt me-3"></span>@lang('igniter.user::default.text_orders')</a>
    <a
        href="{{ page_url('account/reservations') }}"
        wire:navigate
        class="nav-item nav-link fw-bold {{ ($activePage == 'account-reservations') ? 'active' : 'text-reset' }}"
    ><span class="fa fa-calendar me-3"></span>@lang('igniter.user::default.text_reservations')</a>
</div>
