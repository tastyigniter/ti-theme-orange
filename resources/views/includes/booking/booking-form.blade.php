<x-igniter-orange::forms.form id="booking-form" wire:submit="onComplete" novalidate>
    <div class="row g-3 mb-3">
        <div class="col-sm-6">
            <div @class(['form-floating'])>
                <input
                    wire:model="form.firstName"
                    type="text"
                    name="firstName"
                    id="firstName"
                    @class(['form-control', 'is-invalid' => has_form_error('first_name')])
                    placeholder="@lang('igniter.reservation::default.label_first_name')"
                    aria-describedby="firstNameFeedback"
                    required
                />
                <label for="firstName">@lang('igniter.reservation::default.label_first_name')</label>
            </div>
            <x-igniter-orange::forms.error field="form.firstName" id="firstNameFeedback" class="text-danger" />
        </div>
        <div class="col-sm-6">
            <div @class(['form-floating', 'is-invalid' => has_form_error('last_name')])>
                <input
                    wire:model="form.lastName"
                    type="text"
                    name="lastName"
                    id="lastName"
                    @class(['form-control', 'is-invalid' => has_form_error('last_name')])
                    placeholder="@lang('igniter.reservation::default.label_last_name')"
                    aria-describedby="lastNameFeedback"
                    required
                />
                <label for="lastName">@lang('igniter.reservation::default.label_last_name')</label>
            </div>
            <x-igniter-orange::forms.error field="form.lastName" id="lastNameFeedback" class="text-danger" />
        </div>
        <div class="col-sm-6">
            <div @class(['form-floating', 'is-invalid' => has_form_error('email')])>
                <input
                    wire:model="form.email"
                    type="text"
                    name="email"
                    id="email"
                    @class(['form-control', 'is-invalid' => has_form_error('email')])
                    placeholder="@lang('igniter.reservation::default.label_email')"
                    aria-describedby="emailFeedback"
                    required
                />
                <label for="email">@lang('igniter.reservation::default.label_email')</label>
            </div>
            <x-igniter-orange::forms.error field="form.email" id="emailFeedback" class="text-danger" />
        </div>
        <div class="col-sm-6">
            <div @class(['form-floating', 'is-invalid' => has_form_error('telephone')])>
                <input
                    wire:model="form.telephone"
                    data-control="country-code-picker"
                    type="text"
                    name="telephone"
                    id="telephone"
                    @class(['form-control', 'is-invalid' => has_form_error('telephone')])
                    placeholder="@lang('igniter.reservation::default.label_telephone')"
                    aria-describedby="telephoneFeedback"
                    required
                />
                <label for="telephone">@lang('igniter.reservation::default.label_telephone')</label>
            </div>
            <x-igniter-orange::forms.error field="form.telephone" id="telephoneFeedback" class="text-danger" />
        </div>
    </div>

    <div class="mb-4">
        <div @class(['form-floating', 'is-invalid' => has_form_error('comment')])>
            <textarea
                wire:model="form.comment"
                name="comment"
                id="comment"
                rows="4"
                @class(['form-control', 'is-invalid' => has_form_error('comment')])
                placeholder="@lang('igniter.reservation::default.label_comment')"
                aria-describedby="commentFeedback"
            ></textarea>
            <label for="comment">@lang('igniter.reservation::default.label_comment')</label>
        </div>
        <x-igniter-orange::forms.error field="form.comment" id="commentFeedback" class="text-danger" />
    </div>

    <button
        type="submit"
        class="btn btn-primary w-100 btn-lg"
    >@lang('igniter.reservation::default.button_reservation')</button>
</x-igniter-orange::forms.form>
