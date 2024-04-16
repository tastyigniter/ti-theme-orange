{!! form_open([
    'id' => 'contact-form',
    'role' => 'form',
    'method' => 'POST',
    'data-request' => $__SELF__.'::onSubmit',
]) !!}
<div class="row">
    <div class="col-sm-6 col-md-6">
        <div class="form-group">
            <select
                name="subject"
                class="form-select"
            >
                <option>@lang('igniter.frontend::default.contact.text_select_subject')</option>
                @foreach ($__SELF__->subjects as $subject)
                    <option value="@lang($subject)">@lang($subject)</option>
                @endforeach
            </select>
            {!! form_error('subject', '<span class="text-danger">', '</span>') !!}
        </div>
        <div class="form-group">
            <input
                type="text"
                name="email"
                class="form-control"
                value="{{ set_value('email') }}"
                placeholder="@lang('igniter.frontend::default.contact.label_email')"
            />
            {!! form_error('email', '<span class="text-danger">', '</span>') !!}
        </div>
    </div>
    <div class="col-sm-6 col-md-6">
        <div class="form-group">
            <input
                type="text"
                name="full_name"
                class="form-control"
                value="{{ set_value('full_name') }}"
                placeholder="@lang('igniter.frontend::default.contact.label_full_name')"
            />
            {!! form_error('full_name', '<span class="text-danger">', '</span>') !!}
        </div>
        <div class="form-group">
            <input
                type="text"
                name="telephone"
                class="form-control"
                value="{{ set_value('telephone') }}"
                placeholder="@lang('igniter.frontend::default.contact.label_telephone')"
            />
            {!! form_error('telephone', '<span class="text-danger">', '</span>') !!}
        </div>
    </div>
</div>
<div class="form-group">
    <textarea
        name="comment"
        class="form-control"
        rows="5"
        placeholder="@lang('igniter.frontend::default.contact.label_comment')"
    >{{ set_value('comment') }}</textarea>
    {!! form_error('comment', '<span class="text-danger">', '</span>') !!}
</div>

<div class="buttons">
    <button
        type="submit"
        class="btn btn-primary btn-block"
    >@lang('igniter.frontend::default.contact.button_send')</button>
</div>
{!! form_close() !!}
