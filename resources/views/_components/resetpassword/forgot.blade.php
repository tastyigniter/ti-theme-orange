<p>@lang('igniter.user::default.reset.text_summary')</p>

{!! form_open([
    'role' => 'form',
    'method' => 'POST',
    'data-request' => $__SELF__.'::onForgotPassword',
]) !!}
<div class="form-group">
    <input
            name="email"
            type="text"
            id="email"
            class="form-control input-lg"
            value="{{ set_value('email') }}"
            placeholder="@lang('igniter.user::default.reset.label_email')"
    />
    {!! form_error('email', '<span class="text-danger">', '</span>') !!}
</div>

<div class="clearfix">
    <a
            class="btn btn-link btn-lg pull-left"
            href="{{ site_url('account/login') }}"
    >@lang('igniter.user::default.reset.button_login')</a>
    <button
            type="submit"
            class="btn btn-primary btn-lg pull-right"
    >@lang('igniter.user::default.reset.button_reset')</button>
</div>
{!! form_close() !!}
