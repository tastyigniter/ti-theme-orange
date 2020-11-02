{!! $customer
        ? sprintf(lang('igniter.user::default.text_logged_out'), $customer->first_name, 'session::onLogout')
        : sprintf(lang('igniter.user::default.text_logged_in'), $session->loginUrl())
 !!}