<x-igniter-orange::forms.form
    wire:submit="onSave"
    role="form"
>
    <input
        type="hidden"
        wire:model="form.address_id"
    />
    <div class="form-group">
        <label for="address1">@lang('igniter.user::default.account.label_address_1')</label>
        <input
            id="address1"
            wire:model="form.address_1"
            class="form-control"
        />
        <x-igniter-orange::forms.error field="form.address_1" class="text-danger" />
    </div>

    <div class="form-group">
        <label for="address2">@lang('igniter.user::default.account.label_address_2')</label>
        <input
            id="address2"
            wire:model="form.address_2"
            class="form-control"
        />
        <x-igniter-orange::forms.error field="form.address_2" class="text-danger" />
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-4 col-md-4">
            <div class="form-group">
                <label for="city">@lang('igniter.user::default.account.label_city')</label>
                <input
                    id="city"
                    class="form-control"
                    wire:model="form.city"
                />
                <x-igniter-orange::forms.error field="form.city" class="text-danger" />
            </div>
        </div>
        <div class="col-xs-12 col-sm-4 col-md-4">
            <div class="form-group">
                <label for="state">@lang('igniter.user::default.account.label_state')</label>
                <input
                    id="state"
                    class="form-control"
                    wire:model="form.state"
                />
                <x-igniter-orange::forms.error field="form.state" class="text-danger" />
            </div>
        </div>
        <div class="col-xs-12 col-sm-4 col-md-4">
            <div class="form-group">
                <label for="postcode">@lang('igniter.user::default.account.label_postcode')</label>
                <input
                    id="postcode"
                    class="form-control"
                    wire:model="form.postcode"
                />
                <x-igniter-orange::forms.error field="form.postcode" class="text-danger" />
            </div>
        </div>
    </div>

    <div class="form-group">
        <label>@lang('igniter.user::default.account.label_country')</label>
        <select
            class="form-select"
            wire:model="form.country_id"
        >
            <option>@lang('admin::lang.text_select')</option>
            @foreach (countries() as $key => $value)
                <option
                    value="{{ $key }}"
                    {!! $key == $address?->country_id ? ' selected="selected"' : '' !!}
                >{{ $value }}</option>
            @endforeach
        </select>
        <x-igniter-orange::forms.error field="form.country_id" class="text-danger" />
    </div>

    <div class="d-flex justify-content-between">
        <button
            type="submit"
            class="btn btn-primary"
        >@lang('igniter.user::default.account.button_update')</button>
        <a
            class="btn btn-light"
            wire:click="$set('addressId', null)"
        >@lang('igniter.user::default.account.button_back')</a>
    </div>
</x-igniter-orange::forms.form>
