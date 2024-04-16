<h1 class="card-title h4 mb-4 font-weight-normal">
    @lang('igniter.socialite::default.text_confirm_email')
</h1>

<p>@lang('igniter.socialite::default.help_confirm_email')</p>

{!! form_open([
    'role' => 'form',
    'method' => 'POST',
    'data-request' => 'socialite::onConfirmEmail',
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

<button
    type="submit"
    class="btn btn-primary btn-lg btn-block"
>@lang('igniter.socialite::default.button_confirm')</button>
{!! form_close() !!}
