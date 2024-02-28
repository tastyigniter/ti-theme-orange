<div class="p-3">
    <div class="form-group">
        <div class="form-check">
            <input
                wire:model="form.termsAgreed"
                data-checkout-control="termsAgreed"
                id="terms-condition"
                type="checkbox"
                value="1"
                class="form-check-input"
                aria-describedby="termsAgreedFeedback"
            >
            <label class="form-check-label ms-2" for="terms-condition">
                {!! sprintf(lang('igniter.cart::default.checkout.label_terms'), url($agreeTermsSlug)) !!}
            </label>
        </div>
        <x-igniter-orange::forms.error field="form.termsAgreed" id="termsAgreedFeedback" class="text-danger" />
    </div>
</div>
