@php
    $isCustom = $this->tippingSelectedTypeIsCustom();
    $currentAmount = $this->tippingSelectedAmount();
@endphp
<div x-data="{isCustom: '{{$isCustom}}', tipAmount: {{$currentAmount}}}" id="cart-tip" class="mb-3">
    @if ($tipAmounts = $this->tippingAmounts())
        <div class="d-flex flex-wrap justify-content-center pt-2 w-100 text-center tip-amounts">
            <button
                wire:click="onApplyTip(0)"
                wire:loading.class="disabled"
                wire:target="onApplyTip"
                @class(['btn btn-light rounded-pill mb-2 me-2 fw-normal text-nowrap'])
                type="button"
            >@lang('igniter.cart::default.text_no_tip')</button>
            @foreach ($tipAmounts as $tipAmount)
                <button
                    :class="{'active border-secondary': tipAmount == {{$tipAmount->value}}}"
                    wire:click="onApplyTip({{ $tipAmount->value }})"
                    wire:loading.class="disabled"
                    wire:target="onApplyTip"
                    @class(['btn btn-light rounded-pill mb-2 me-2 fw-normal text-nowrap'])
                    type="button"
                >{{ $tipAmount->valueType != 'F' ? round($tipAmount->value).'%' : currency_format($tipAmount->value) }}</button>
            @endforeach
            <button
                x-on:click="isCustom = !isCustom"
                :class="{'active border-secondary': isCustom}"
                wire:loading.class="disabled"
                wire:target="onApplyTip"
                @class(['btn btn-light rounded-pill mb-2 fw-normal text-nowrap'])
                type="button"
            >@lang('igniter.cart::default.text_edit_tip')</button>
        </div>
    @endif
    <x-igniter-orange::forms.form
        x-cloak
        x-show="isCustom"
        id="tip-form"
        wire:submit="onApplyTip(tipAmount, true)"
    >
        <div class="input-group{{ $tipAmounts ? ' mt-2' : '' }}">
            <input
                x-model="tipAmount"
                type="number"
                class="form-control rounded-pill"
                placeholder="@lang('igniter.cart::default.text_apply_tip')"
                step="{{ 1 / (10 ** app('currency')->getDefault()->decimal_position) }}"
            />
            <button
                type="submit"
                class="btn btn btn-secondary rounded-pill ms-3"
                wire:loading.class="disabled"
                title="@lang('igniter.cart::default.button_apply_tip')"
            ><i wire:loading.class="fa-spinner fa-spin" class="fa fa-check"></i></button>
        </div>
    </x-igniter-orange::forms.form>
</div>
