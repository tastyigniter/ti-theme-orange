<x-igniter-orange::forms.form id="checkout-form" novalidate>
    <div class="p-3">
        <h5 class="fw-normal">@lang('igniter.orange::default.label_your_details')</h5>
        @include('igniter-orange::includes.checkout.customer-fields')
    </div>

    <div class="px-3 fs-5">
        <div class="p-3 border rounded">
            <x-igniter-orange::fulfillment/>
        </div>
    </div>

    @includeWhen($order->isDeliveryType(), 'igniter-orange::includes.checkout.address-fields')

    <div class="p-3">
        @includeWhen($showCommentField, 'igniter-orange::includes.checkout.comment-field')
        @includeWhen($order->isDeliveryType() && $showDeliveryCommentField, 'igniter-orange::includes.checkout.delivery-comment-field')
    </div>

    @includeWhen($this->paymentGateways->isNotEmpty(), 'igniter-orange::includes.checkout.payments')

    @includeWhen($agreeTermsSlug, 'igniter-orange::includes.checkout.terms-field')

    <div class="p-3">
        <button
            wire:loading.class="disabled"
            data-checkout-control="submit"
            type="submit"
            class="checkout-btn btn btn-primary w-100 btn-lg"
        >@lang('igniter.orange::default.button_confirm')</button>
    </div>
</x-igniter-orange::forms.form>
