<div class="row g-3 mb-1">
    <div class="col-sm-6">
        <div @class(['form-floating', 'is-invalid' => has_form_error('first_name')])>
            <input
                wire:model="form.first_name"
                type="text"
                id="firstName"
                @class(['form-control', 'is-invalid' => has_form_error('first_name')])
                placeholder="@lang('igniter.cart::default.checkout.label_first_name')"
                aria-describedby="firstNameFeedback"
                required
            />
            <label for="firstName">@lang('igniter.cart::default.checkout.label_first_name')</label>
        </div>
        <x-igniter-orange::forms.error field="form.first_name" id="firstNameFeedback" class="text-danger" />
    </div>
    <div class="col-sm-6">
        <div @class(['form-floating', 'is-invalid' => has_form_error('last_name')])>
            <input
                wire:model="form.last_name"
                type="text"
                id="lastName"
                @class(['form-control', 'is-invalid' => has_form_error('last_name')])
                placeholder="@lang('igniter.cart::default.checkout.label_last_name')"
                aria-describedby="lastNameFeedback"
                required
            />
            <label for="lastName">@lang('igniter.cart::default.checkout.label_last_name')</label>
        </div>
        <x-igniter-orange::forms.error field="form.last_name" id="lastNameFeedback" class="text-danger" />
    </div>
    <div class="col-sm-6">
        <div @class(['form-floating', 'is-invalid' => has_form_error('email')])>
            <input
                wire:model="form.email"
                type="text"
                id="email"
                @class(['form-control', 'is-invalid' => has_form_error('email')])
                placeholder="@lang('igniter.cart::default.checkout.label_email')"
                aria-describedby="emailFeedback"
                required
            />
            <label for="email">@lang('igniter.cart::default.checkout.label_email')</label>
        </div>
        <x-igniter-orange::forms.error field="form.email" id="emailFeedback" class="text-danger" />
    </div>
    <div class="col-sm-6">
        <div @class(['form-floating', 'is-invalid' => has_form_error('telephone')])>
            <input
                wire:model="form.telephone"
                type="text"
                name="telephone"
                id="telephone"
                @class(['form-control', 'is-invalid' => has_form_error('telephone')])
                placeholder="@lang('igniter.cart::default.checkout.label_telephone')"
                aria-describedby="telephoneFeedback"
                required
            />
            <label for="telephone">@lang('igniter.cart::default.checkout.label_telephone')</label>
        </div>
        <x-igniter-orange::forms.error field="form.telephone" id="telephoneFeedback" class="text-danger" />
    </div>
</div>
