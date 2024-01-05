<form
        method="POST"
        accept-charset="utf-8"
        data-request="{{ $submitAddressEventHandler }}"
        role="form"
>
    <input
            type="hidden"
            name="address[address_id]"
            value="{{ set_value('address[address_id]', $address->address_id) }}"
    />
    <div class="form-group">
        <label>@lang('igniter.user::default.account.label_address_1')</label>
        <input
                type="text"
                name="address[address_1]"
                class="form-control"
                value="{{ set_value('address[address_1]', $address->address_1) }}"
        />
        {!! form_error('address.address_1', '<span class="text-danger">', '</span>') !!}
    </div>

    <div class="form-group">
        <label>@lang('igniter.user::default.account.label_address_2')</label>
        <input
                type="text"
                name="address[address_2]"
                class="form-control"
                value="{{ set_value('address[address_2]', $address->address_2) }}"
        />
        {!! form_error('address.address_2', '<span class="text-danger">', '</span>') !!}
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-4 col-md-4">
            <div class="form-group">
                <label>@lang('igniter.user::default.account.label_city')</label>
                <input
                        type="text"
                        class="form-control"
                        name="address[city]"
                        value="{{ set_value('address[city]', $address->city) }}"
                        placeholder="@lang('igniter.user::default.account.label_city')"
                >
                {!! form_error('address.city', '<span class="text-danger">', '</span>') !!}
            </div>
        </div>
        <div class="col-xs-12 col-sm-4 col-md-4">
            <div class="form-group">
                <label>@lang('igniter.user::default.account.label_state')</label>
                <input
                        type="text"
                        class="form-control"
                        value="{{ set_value('address[state]', $address->state) }}"
                        name="address[state]"
                        placeholder="@lang('igniter.user::default.account.label_state')"
                >
                {!! form_error('address.state', '<span class="text-danger">', '</span>') !!}
            </div>
        </div>
        <div class="col-xs-12 col-sm-4 col-md-4">
            <div class="form-group">
                <label>@lang('igniter.user::default.account.label_postcode')</label>
                <input
                        type="text"
                        class="form-control"
                        name="address[postcode]"
                        value="{{ set_value('address[postcode]', $address->postcode) }}"
                        placeholder="@lang('igniter.user::default.account.label_postcode')"
                >
                {!! form_error('address.postcode', '<span class="text-danger">', '</span>') !!}
            </div>
        </div>
    </div>

    <div class="form-group">
        <label>@lang('igniter.user::default.account.label_country')</label>
        <select name="address[country_id]" class="form-select">
            @foreach (countries() as $key => $value)
                <option
                        value="{{ $key }}"
                        {!! $key == $address->country_id ? ' selected="selected"' : '' !!}
                >{{ $value }}</option>
            @endforeach
        </select>
        {!! form_error('address.country', '<span class="text-danger">', '</span>') !!}
    </div>

    <div class="d-flex justify-content-between">
        <button
                type="submit"
                class="btn btn-primary"
        >@lang('igniter.user::default.account.button_update')</button>
        <a
                class="btn btn-light"
                href="{{ site_url('account/address') }}"
        >@lang('igniter.user::default.account.button_back')</a>
    </div>
</form>
