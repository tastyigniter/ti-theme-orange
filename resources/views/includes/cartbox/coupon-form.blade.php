<div x-data="{couponCode: '{{ $cart->getCondition('coupon')?->getMetaData('code') }}'}" id="cart-coupon" class="py-3">
    <x-igniter-orange::forms.form id="coupon-form" wire:submit="onApplyCoupon(couponCode)">
        <div class="cart-coupon">
            <div class="input-group input-group-lg">
                <input
                    x-model="couponCode"
                    type="text"
                    class="form-control rounded-pill"
                    placeholder="@lang('igniter.cart::default.text_apply_coupon')"
                />

                <button
                    type="submit"
                    class="btn btn btn-secondary rounded-pill ms-2"
                    data-replace-loading="fa fa-spinner fa-spin"
                ><i class="fa fa-check"></i></button>
            </div>
        </div>
    </x-igniter-orange::forms.form>
</div>
