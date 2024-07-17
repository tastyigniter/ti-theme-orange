<div class="p-3 pb-0">
    @if(!count($this->customerAddresses))
        <h5 class="fw-normal mt-2">@lang('igniter.cart::default.checkout.label_address')</h5>
    @else
        <div class="form-group">
            <div class="form-floating">
                <select
                    wire:model.change="form.address_id"
                    data-checkout-control="address_id"
                    class="form-select"
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
            <x-igniter-orange::forms.error field="form.address_id" id="addressIdFeedback" class="text-danger" />
        </div>
    @endif

    <div>
        <div class="row g-3 mb-1">
            <div class="col-sm-6">
                <div @class(['form-floating', 'is-invalid' => has_form_error('form.address_1')])>
                    <input
                        wire:model="form.address_1"
                        data-checkout-control="address_1"
                        type="text"
                        @class(['form-control', 'is-invalid' => has_form_error('form.address_1')])
                        placeholder="@lang('igniter.cart::default.checkout.label_address_1')"
                        aria-describedby="addressOneFeedback"
                        required
                    />
                    <label for="">@lang('igniter.cart::default.checkout.label_address_1')</label>
                </div>
                <x-igniter-orange::forms.error field="form.address_1" id="addressOneFeedback" class="text-danger" />
            </div>
            @if ($showAddress2Field)
                <div class="col-sm-6">
                    <div @class(['form-floating', 'is-invalid' => has_form_error('form.address_2')])>
                        <input
                            wire:model="form.address_2"
                            data-checkout-control="address_2"
                            type="text"
                            @class(['form-control', 'is-invalid' => has_form_error('form.address_2')])
                            placeholder="@lang('igniter.cart::default.checkout.label_address_2')"
                            aria-describedby="addressTwoFeedback"
                        />
                        <label for="">@lang('igniter.cart::default.checkout.label_address_2')</label>
                    </div>
                    <x-igniter-orange::forms.error field="form.address_2" id="addressTwoFeedback" class="text-danger" />
                </div>
            @endif
            @if ($showCityField)
                <div class="col-sm-4">
                    <div @class(['form-floating', 'is-invalid' => has_form_error('form.city')])>
                        <input
                            wire:model="form.city"
                            data-checkout-control="city"
                            type="text"
                            @class(['form-control', 'is-invalid' => has_form_error('form.city')])
                            placeholder="@lang('igniter.cart::default.checkout.label_city')"
                            aria-describedby="cityFeedback"
                        />
                        <label for="">@lang('igniter.cart::default.checkout.label_city')</label>
                    </div>
                    <x-igniter-orange::forms.error field="form.city" id="cityFeedback" class="text-danger" />
                </div>
            @endif
            @if ($showStateField)
                <div class="col-sm-4">
                    <div @class(['form-floating', 'is-invalid' => has_form_error('form.state')])>
                        <input
                            wire:model="form.state"
                            data-checkout-control="state"
                            type="text"
                            @class(['form-control', 'is-invalid' => has_form_error('form.state')])
                            placeholder="@lang('igniter.cart::default.checkout.label_state')"
                            aria-describedby="stateFeedback"
                        />
                        <label for="">@lang('igniter.cart::default.checkout.label_state')</label>
                    </div>
                    <x-igniter-orange::forms.error field="form.state" id="stateFeedback" class="text-danger" />
                </div>
            @endif
            @if ($showPostcodeField)
                <div class="col-sm-4">
                    <div @class(['form-floating', 'is-invalid' => has_form_error('form.postcode')])>
                        <input
                            wire:model="form.postcode"
                            data-checkout-control="postcode"
                            type="text"
                            @class(['form-control', 'is-invalid' => has_form_error('form.postcode')])
                            placeholder="@lang('igniter.cart::default.checkout.label_postcode')"
                            aria-describedby="postcodeFeedback"
                        />
                        <label for="">@lang('igniter.cart::default.checkout.label_postcode')</label>
                    </div>
                    <x-igniter-orange::forms.error field="form.postcode" id="postcodeFeedback" class="text-danger" />
                </div>
            @endif
            @if ($showCountryField)
                <div @class(['form-floating', 'is-invalid' => has_form_error('form.country_id')])>
                    <select
                        wire:model="form.country_id"
                        data-checkout-control="country_id"
                        @class(['form-select', 'is-invalid' => has_form_error('form.country_id')])
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
                <x-igniter-orange::forms.error field="form.country_id" id="countryFeedback" class="text-danger" />
            @endif
        </div>
    </div>
</div>
