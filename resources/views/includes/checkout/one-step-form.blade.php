<x-igniter-orange::forms.form wire:submit="onConfirm" id="checkout-form" novalidate>
    <div class="mb-4">
        <h5 class="card-title fw-normal mb-3">@lang('igniter.orange::default.label_your_details')</h5>
        @include('igniter-orange::includes.checkout.customer-fields')
    </div>

    @includeWhen($order->isDeliveryType(), 'igniter-orange::includes.checkout.address-fields')

    <div class="mb-4 py-3 border-top border-bottom border-2 fs-5">
        <x-igniter-orange::local-control />
    </div>

    @includeWhen($this->paymentGateways->isNotEmpty(), 'igniter-orange::includes.checkout.payments')

    @includeWhen($showCommentField, 'igniter-orange::includes.checkout.comment-field')

    @includeWhen($showDeliveryCommentField, 'igniter-orange::includes.checkout.delivery-comment-field')

    @includeWhen($agreeTermsSlug, 'igniter-orange::includes.checkout.terms-field')

    <div class="mb-4">
        <button
            type="submit"
            class="btn btn-primary w-100 btn-lg"
            wire:loading.class="disabled"
        >@lang('igniter.orange::default.button_confirm')</button>
    </div>
</x-igniter-orange::forms.form>
