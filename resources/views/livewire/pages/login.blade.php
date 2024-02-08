<div class="card">
    <div class="card-body">
        <h1 class="card-title h4 mb-4 font-weight-normal">
            @lang('main::lang.account.login.text_login')
        </h1>
        @include('igniter-orange::includes.account.login-form')
        <livewire:igniter-orange::socialite />
        <div class="row">
            <div class="col-md-5 p-sm-0">
                <a wire:navigate class="btn btn-link btn-lg" href="{{ site_url('account/reset') }}">
                    <span class="small">@lang('main::lang.account.login.text_forgot')</span>
                </a>
            </div>
            @if ((bool)$canRegister)
                <div class="col-sm-7">
                    <a
                        wire:navigate
                        class="btn btn-outline-default w-100 btn-lg"
                        href="{{ site_url('account/register') }}"
                    >@lang('main::lang.account.login.button_register')</a>
                </div>
            @endif
        </div>
    </div>
</div>
