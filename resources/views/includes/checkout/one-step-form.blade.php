<x-igniter-orange::forms.form id="checkout-form" novalidate>
    <div class="p-3">
        <h5 class="card-title mb-3">@lang('igniter.orange::default.label_your_details')</h5>
        @include('igniter-orange::includes.checkout.customer-fields')
    </div>

    @includeWhen($order->isDeliveryType(), 'igniter-orange::includes.checkout.address-fields')

    <div class="p-3 border-top border-bottom fs-5">
        <x-igniter-orange::fulfillment />
    </div>

    @includeWhen($showCommentField, 'igniter-orange::includes.checkout.comment-field')

    @includeWhen($showDeliveryCommentField, 'igniter-orange::includes.checkout.delivery-comment-field')

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