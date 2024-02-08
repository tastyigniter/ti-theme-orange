<x-igniter-orange::forms.form id="register-form" wire:submit="onRegister">
    <div class="form-row">
        <div class="col-sm-6">
            <div class="form-group">
                <input
                    id="first-name"
                    class="form-control input-lg"
                    wire:model="form.first_name"
                    placeholder="@lang('igniter.user::default.settings.label_first_name')"
                />
                <x-igniter-orange::forms.error field="form.first_name" class="text-danger" />
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <input
                    id="last-name"
                    class="form-control input-lg"
                    wire:model="form.last_name"
                    placeholder="@lang('igniter.user::default.settings.label_last_name')"
                />
                <x-igniter-orange::forms.error field="form.last_name" class="text-danger" />
            </div>
        </div>
    </div>
    <div class="form-group">
        <input
            type="email"
            id="email"
            class="form-control input-lg"
            wire:model="form.email"
            placeholder="@lang('igniter.user::default.settings.label_email')"
        />
        <x-igniter-orange::forms.error field="form.email" class="text-danger" />
    </div>
    <div class="form-row">
        <div class="col-sm-6">
            <div class="form-group">
                <input
                    type="password"
                    id="password"
                    class="form-control input-lg"
                    wire:model="form.password"
                    placeholder="@lang('igniter.user::default.login.label_password')"
                />
                <x-igniter-orange::forms.error field="form.password" class="text-danger" />
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <input
                    type="password"
                    id="password-confirm"
                    class="form-control input-lg"
                    wire:model="form.password_confirmation"
                    placeholder="@lang('igniter.user::default.login.label_password_confirm')"
                />
                <x-igniter-orange::forms.error field="form.password_confirmation" class="text-danger" />
            </div>
        </div>
    </div>

    <div class="form-group">
        <input
            id="telephone"
            class="form-control input-lg"
            wire:model="form.telephone"
            data-control="country-code-picker"
            data-initial-country="gb"
            placeholder="@lang('igniter.user::default.settings.label_telephone')"
        />
        <x-igniter-orange::forms.error field="form.telephone" class="text-danger" />
    </div>

    <div class="form-group">
        <div class="form-check">
            <input
                id="newsletter"
                type="checkbox"
                wire:model="form.newsletter"
                value="1"
                class="form-check-input"
            />
            <label class="form-check-label" for="newsletter">
                @lang('igniter.user::default.login.label_newsletter')
            </label>
        </div>
        <x-igniter-orange::forms.error field="form.newsletter" class="text-danger" />
    </div>

    @if ($requireRegistrationTerms && $agreeTermsSlug)
        <div class="form-group">
            <div class="form-check">
                <input
                    type="checkbox"
                    id="agree-terms"
                    wire:model="form.terms"
                    value="1"
                    class="form-check-input"
                />
                <label class="form-check-label" for="agree-terms">
                    {!! sprintf(lang('igniter.user::default.login.label_terms'), url($agreeTermsSlug)) !!}
                </label>
            </div>
            <x-igniter-orange::forms.error field="form.terms" class="text-danger" />
        </div>
    @endif

    <div class="row">
        <div class="col-12 mb-2">
            <button
                type="submit"
                class="btn btn-primary w-100 btn-lg"
                wire:loading.class="disabled"
            >@lang('igniter.user::default.login.button_register')</button>
        </div>
    </div>
</x-igniter-orange::forms.form>
