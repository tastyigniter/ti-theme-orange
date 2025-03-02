<div class="p-3 border-bottom border-top">
    <h5 class="card-title mb-2">@lang('igniter.cart::default.checkout.label_payment_method')</h5>
    <div data-toggle="payments" class="progress-indicator-container">
        <div class="list-group list-group-flush">
            @foreach ($this->paymentGateways as $paymentMethod)
                @php
                    $paymentIsSelected = ($this->form->payment == $paymentMethod->code);
                    $paymentIsNotApplicable = !$paymentMethod->isApplicable($order->order_total, $paymentMethod);
                @endphp
                <div
                    class="list-group-item px-0"
                    data-checkout-control="choose-payment"
                    data-payment-code="{{ $paymentMethod->code }}"
                >
                    <div class="form-check">
                        <input
                            data-checkout-control="payment"
                            data-pre-validate-checkout="{{ $paymentMethod->completesPaymentOnClient() ? 'true' : 'false' }}"
                            type="radio"
                            name="form.payment"
                            id="payment-{{ $paymentMethod->code }}"
                            class="form-check-input"
                            value="{{ $paymentMethod->code }}"
                            @checked($paymentIsSelected)
                            @disabled($paymentIsNotApplicable)
                            autocomplete="off"
                        />
                        <label
                            class="form-check-label ms-2 d-block"
                            for="payment-{{ $paymentMethod->code }}"
                        >
                            <div class="">{{ $paymentMethod->name }}</div>
                            @if(strlen($paymentMethod->description))
                                <div class="small text-muted fw-normal">
                                    {!! $paymentMethod->description !!}
                                </div>
                            @endif
                            @if($paymentIsNotApplicable)
                                <div class="small text-muted fw-normal">
                                    <em>
                                        {!! sprintf(
                                            lang('igniter.payregister::default.alert_min_order_total'),
                                            currency_format($paymentMethod->order_total),
                                            lang('igniter.payregister::default.text_this_payment')
                                        ) !!}
                                    </em>
                                </div>
                            @endif
                            @if($paymentMethod->hasApplicableFee())
                                <div class="small text-muted fw-normal">
                                    <em>
                                        {!! sprintf(
                                            lang('igniter.payregister::default.alert_order_fee'),
                                            $paymentMethod->getFormattedApplicableFee(),
                                            lang('igniter.payregister::default.text_this_payment')
                                        ) !!}
                                    </em>
                                </div>
                            @endif
                        </label>
                        @includeWhen(($viewName = $paymentMethod->getPaymentFormViewName()) && $paymentIsSelected, $viewName)
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <x-igniter-orange::forms.error field="form.payment" id="paymentFeedback" class="text-danger"/>
</div>
