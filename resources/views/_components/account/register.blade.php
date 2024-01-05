@if ($canRegister)
    {!! form_open([
        'role' => 'form',
        'method' => 'POST',
        'data-request' => 'account::onRegister',
    ]) !!}

    <div class="form-row">
        <div class="col-sm-6">
            <div class="form-group">
                <input
                        type="text"
                        id="first-name"
                        class="form-control input-lg"
                        value="{{ set_value('first_name') }}"
                        name="first_name"
                        placeholder="@lang('igniter.user::default.settings.label_first_name')"
                        autofocus="">
                {!! form_error('first_name', '<span class="text-danger">', '</span>') !!}
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <input
                        type="text"
                        id="last-name"
                        class="form-control input-lg"
                        value="{{ set_value('last_name') }}"
                        name="last_name"
                        placeholder="@lang('igniter.user::default.settings.label_last_name')">
                {!! form_error('last_name', '<span class="text-danger">', '</span>') !!}
            </div>
        </div>
    </div>
    <div class="form-group">
        <input
                type="text"
                id="email"
                class="form-control input-lg"
                value="{{ set_value('email') }}"
                name="email"
                placeholder="@lang('igniter.user::default.settings.label_email')">
        {!! form_error('email', '<span class="text-danger">', '</span>') !!}
    </div>
    <div class="form-row">
        <div class="col-sm-6">
            <div class="form-group">
                <input
                        type="password"
                        id="password"
                        class="form-control input-lg"
                        value=""
                        name="password"
                        placeholder="@lang('igniter.user::default.login.label_password')">
                {!! form_error('password', '<span class="text-danger">', '</span>') !!}
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <input
                        type="password"
                        id="password-confirm"
                        class="form-control input-lg"
                        name="password_confirm"
                        value=""
                        placeholder="@lang('igniter.user::default.login.label_password_confirm')">
                {!! form_error('password_confirm', '<span class="text-danger">', '</span>') !!}
            </div>
        </div>
    </div>

    <div class="form-group">
        <input
                type="text"
                id="telephone"
                class="form-control input-lg"
                value="{{ set_value('telephone') }}"
                name="telephone"
                data-control="country-code-picker"
                data-initial-country="gb"
                placeholder="@lang('igniter.user::default.settings.label_telephone')"
        >
        {!! form_error('telephone', '<span class="text-danger">', '</span>') !!}
    </div>

    <div class="form-group">
        <div class="form-check">
            <input
                    id="newsletter"
                    type="checkbox"
                    name="newsletter"
                    value="1"
                    class="form-check-input"
                    {!! set_checkbox('newsletter', '1') !!}
            >
            <label class="form-check-label" for="newsletter">
                @lang('igniter.user::default.login.label_newsletter')
            </label>
        </div>
        {!! form_error('newsletter', '<span class="text-danger">', '</span>') !!}
    </div>

    @if ($requireRegistrationTerms && $registrationTermsSlug = $account->getRegistrationTermsPageSlug())
        <div class="form-group">
            <div class="form-check">
                <input
                        id="agree-terms"
                        type="checkbox"
                        name="terms"
                        value="1"
                        class="form-check-input"
                        {!! set_checkbox('terms', '1') !!}
                >
                <label class="form-check-label" for="agree-terms">
                    {!! sprintf(lang('igniter.user::default.login.label_terms'), url($registrationTermsSlug)) !!}
                </label>
            </div>
            {!! form_error('terms', '<span class="text-danger">', '</span>') !!}
        </div>
    @endif

    <div class="row">
        <div class="col-12 mb-2">
            <button
                    type="submit"
                    class="btn btn-primary btn-block btn-lg"
                    data-attach-loading
            >@lang('igniter.user::default.login.button_register')</button>
        </div>
        <div class="col-12 text-center">
            <a
                    href="{{ site_url('account/login') }}"
                    class="btn btn-link"
            >@lang('igniter.user::default.login.button_login')</a>
        </div>
    </div>
    {!! form_close() !!}
@else
    <p>@lang('igniter.user::default.login.alert_registration_disabled')</p>
@endif
