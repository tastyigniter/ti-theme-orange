<div class="mb-4">
    <div class="form-group">
        <div class="form-check">
            <input
                id="terms-condition"
                type="checkbox"
                name="terms_condition"
                value="1"
                class="form-check-input" {!! set_checkbox('terms_condition', '1') !!}
            >
            <label class="form-check-label ms-2" for="terms-condition">
                {!! sprintf(lang('igniter.cart::default.checkout.label_terms'), url($agreeTermsSlug)) !!}
            </label>
        </div>
        {!! form_error('terms_condition', '<span class="text-danger col-xs-12">', '</span>') !!}
    </div>
</div>
