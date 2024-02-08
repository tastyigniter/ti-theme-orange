<div class="mb-4">
    @if(!count($this->customerAddresses))
        <h5 class="card-title fw-normal mb-3">@lang('igniter.cart::default.checkout.label_address')</h5>
    @else
        <div class="form-group">
            <div class="form-floating">
                <select
                    wire:model.live="form.addressId"
                    class="form-select"
                    name="addressId"
                    aria-describedby="addressIdFeedback"
                >
                    <option value="0">@lang('igniter.cart::default.checkout.text_address')</option>
                    @foreach ($this->customerAddresses as $address)
                        <option
                            value="{{ $address->address_id }}"
                            @checked($order->address_id == $address->address_id)
                        >{{ $address->formatted_address }}</option>
                    @endforeach
                </select>
                <label for="addressId">@lang('igniter.cart::default.checkout.text_delivery_address')</label>
            </div>
            <x-igniter-orange::forms.error field="form.addressId" id="addressIdFeedback" class="text-danger" />
        </div>
    @endif

    <div @class(['mt-3'])>
        <input
            wire:model.fill="form.address.address_id"
            type="hidden"
            name="address[address_id]"
        >
        <div class="row g-3 mb-1">
            <div class="col-sm-6">
                <div @class(['form-floating', 'is-invalid' => has_form_error('address.address_1')])>
                    <input
                        wire:model="form.address.address_1"
                        type="text"
                        name="address[address_1]"
                        @class(['form-control', 'is-invalid' => has_form_error('address.address_1')])
                        placeholder="@lang('igniter.cart::default.checkout.label_address_1')"
                        aria-describedby="addressOneFeedback"
                        required
                    />
                    <label for="">@lang('igniter.cart::default.checkout.label_address_1')</label>
                </div>
                <x-igniter-orange::forms.error field="form.address.address_1" id="addressOneFeedback" class="text-danger" />
            </div>
            @if ($showAddress2Field)
                <div class="col-sm-6">
                    <div @class(['form-floating', 'is-invalid' => has_form_error('address.address_2')])>
                        <input
                            wire:model="form.address.address_2"
                            type="text"
                            name="address[address_2]"
                            @class(['form-control', 'is-invalid' => has_form_error('address.address_2')])
                            placeholder="@lang('igniter.cart::default.checkout.label_address_2')"
                            aria-describedby="addressTwoFeedback"
                        />
                        <label for="">@lang('igniter.cart::default.checkout.label_address_2')</label>
                    </div>
                    <x-igniter-orange::forms.error field="form.address.address_2" id="addressTwoFeedback" class="text-danger" />
                </div>
            @endif
            @if ($showCityField)
                <div class="col-sm-4">
                    <div @class(['form-floating', 'is-invalid' => has_form_error('address.city')])>
                        <input
                            wire:model="form.address.city"
                            type="text"
                            name="address[city]"
                            @class(['form-control', 'is-invalid' => has_form_error('address.city')])
                            placeholder="@lang('igniter.cart::default.checkout.label_city')"
                            aria-describedby="cityFeedback"
                        />
                        <label for="">@lang('igniter.cart::default.checkout.label_city')</label>
                    </div>
                    <x-igniter-orange::forms.error field="form.address.city" id="cityFeedback" class="text-danger" />
                </div>
            @endif
            @if ($showStateField)
                <div class="col-sm-4">
                    <div @class(['form-floating', 'is-invalid' => has_form_error('address.state')])>
                        <input
                            wire:model="form.address.state"
                            type="text"
                            name="address[state]"
                            @class(['form-control', 'is-invalid' => has_form_error('address.state')])
                            placeholder="@lang('igniter.cart::default.checkout.label_state')"
                            aria-describedby="stateFeedback"
                        />
                        <label for="">@lang('igniter.cart::default.checkout.label_state')</label>
                    </div>
                    <x-igniter-orange::forms.error field="form.address.state" id="stateFeedback" class="text-danger" />
                </div>
            @endif
            @if ($showPostcodeField)
                <div class="col-sm-4">
                    <div @class(['form-floating', 'is-invalid' => has_form_error('address.postcode')])>
                        <input
                            wire:model="form.address.postcode"
                            type="text"
                            name="address[postcode]"
                            @class(['form-control', 'is-invalid' => has_form_error('address.postcode')])
                            value="{{ set_value('address[postcode]', $order->address['postcode'] ?? '') }}"
                            placeholder="@lang('igniter.cart::default.checkout.label_postcode')"
                            aria-describedby="postcodeFeedback"
                        />
                        <label for="">@lang('igniter.cart::default.checkout.label_postcode')</label>
                    </div>
                    <x-igniter-orange::forms.error field="form.address.postcode" id="postcodeFeedback" class="text-danger" />
                </div>
            @endif
            @if ($showCountryField)
                <div @class(['form-floating', 'is-invalid' => has_form_error('address.country_id')])>
                    <select
                        wire:model="form.address.country_id"
                        name="address[country_id]"
                        @class(['form-select', 'is-invalid' => has_form_error('address.country_id')])
                        aria-describedby="countryFeedback"
                    >
                        @foreach (countries('country_name') as $key => $value)
                            <option
                                value="{{ $key }}"
                                {!! ($key == $order->address['country_id']) ? 'selected="selected"' : '' !!}
                            >{{ $value }}</option>
                        @endforeach
                    </select>
                    <label for="">@lang('igniter.cart::default.checkout.label_country')</label>
                </div>
                <x-igniter-orange::forms.error field="form.address.country_id" id="countryFeedback" class="text-danger" />
            @endif
        </div>
    </div>
</div>
