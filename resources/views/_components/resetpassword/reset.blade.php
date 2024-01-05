{!! form_open([
    'role' => 'form',
    'method' => 'POST',
    'data-request' => $__SELF__.'::onResetPassword',
]) !!}

<input
        name="code"
        type="hidden"
        class="form-control input-lg"
        value="{{ set_value('code', $__SELF__->resetCode()) }}"
/>
{!! form_error('code', '<span class="text-danger">', '</span>') !!}

<div class="form-group">
    <input
            name="password"
            type="password"
            class="form-control input-lg"
            value="{{ set_value('password') }}"
            placeholder="@lang('igniter.user::default.reset.label_password')"
    />
    {!! form_error('password', '<span class="text-danger">', '</span>') !!}
</div>

<div class="form-group">
    <input
            name="password_confirm"
            type="password"
            class="form-control input-lg"
            value="{{ set_value('password_confirm') }}"
            placeholder="@lang('igniter.user::default.reset.label_password_confirm')"
    />
    {!! form_error('password_confirm', '<span class="text-danger">', '</span>') !!}
</div>

<div class="clearfix">
    <button
            type="submit"
            class="btn btn-primary btn-block btn-lg"
    >@lang('igniter.user::default.reset.button_reset')</button>
</div>

{!! form_close() !!}
