<div class="row g-3 mb-1">
    <div class="col-sm-6">
        <div @class(['form-floating', 'is-invalid' => has_form_error('form.first_name')])>
            <input
                wire:model="form.first_name"
                data-checkout-control="first_name"
                type="text"
                id="firstName"
                @class(['form-control', 'is-invalid' => has_form_error('form.first_name')])
                placeholder="@lang('igniter.cart::default.checkout.label_first_name')"
                aria-describedby="firstNameFeedback"
                required
            />
            <label for="firstName">@lang('igniter.cart::default.checkout.label_first_name')</label>
        </div>
        <x-igniter-orange::forms.error field="form.first_name" id="firstNameFeedback" class="text-danger" />
    </div>
    <div class="col-sm-6">
        <div @class(['form-floating', 'is-invalid' => has_form_error('form.last_name')])>
            <input
                wire:model="form.last_name"
                data-checkout-control="last_name"
                type="text"
                id="lastName"
                @class(['form-control', 'is-invalid' => has_form_error('form.last_name')])
                placeholder="@lang('igniter.cart::default.checkout.label_last_name')"
                aria-describedby="lastNameFeedback"
                required
            />
            <label for="lastName">@lang('igniter.cart::default.checkout.label_last_name')</label>
        </div>
        <x-igniter-orange::forms.error field="form.last_name" id="lastNameFeedback" class="text-danger" />
    </div>
    <div class="col-sm-6">
        <div @class(['form-floating', 'is-invalid' => has_form_error('form.email')])>
            <input
                wire:model="form.email"
                data-checkout-control="email"
                type="text"
                id="email"
                @class(['form-control', 'is-invalid' => has_form_error('form.email')])
                placeholder="@lang('igniter.cart::default.checkout.label_email')"
                aria-describedby="emailFeedback"
                required
            />
            <label for="email">@lang('igniter.cart::default.checkout.label_email')</label>
        </div>
        <x-igniter-orange::forms.error field="form.email" id="emailFeedback" class="text-danger" />
    </div>
    <div class="col-sm-6">
        <div @class(['form-group form-control py-0', 'is-invalid' => has_form_error('form.telephone')])>
            <label for="telephone">@lang('igniter.cart::default.checkout.label_telephone')</label>
            <input
                wire:model="form.telephone"
                data-checkout-control="telephone"
                data-control="country-code-picker"
                data-container-class="w-100"
                type="text"
                name="telephone"
                id="telephone"
                @class(['form-control shadow-none border-none'])
                aria-describedby="telephoneFeedback"
                required
            />
        </div>
        <x-igniter-orange::forms.error field="form.telephone" id="telephoneFeedback" class="text-danger" />
    </div>
</div>
