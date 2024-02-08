<div class="card">
    <div class="card-body">
        <h1 class="card-title h4 mb-4 font-weight-normal">
            @lang('main::lang.account.login.text_register')
        </h1>

        @if ($canRegister)
            @include('igniter-orange::includes.account.register-form')
            <div class="text-center">
                <a
                    href="{{ site_url('account/login') }}"
                    class="btn btn-link"
                >@lang('igniter.user::default.login.button_login')</a>
            </div>
        @else
            <p>@lang('igniter.user::default.login.alert_registration_disabled')</p>
        @endif
    </div>
</div>
