<?php if ($cart->count()) { ?>
    <form
        id="tip-form"
        method="POST"
        role="form"
        data-request="<?= $applyTipEventHandler; ?>"
    >
        <div class="cart-tip">
            <div
                class="input-group">
                <input
                    type="text"
                    name="tip_amount"
                    class="form-control"
                    value="<?= ($coupon = $cart->getCondition('coupon')) ? $coupon->getMetaData('code') : '' ?>"
                    placeholder="<?= lang('igniter.cart::default.text_apply_tip'); ?>"
                	inputmode="numeric" 
                	pattern="[0-9\.]*"    
                />
                <span class="input-group-append">
                <button
                    type="submit"
                    class="btn btn-light"
                    data-replace-loading="fa fa-spinner fa-spin"
                    title="<?= lang('igniter.cart::default.button_apply_tip'); ?>"
                ><i class="fa fa-check"></i></button>
            </span>
            </div>
        </div>
    </form>
<?php } ?>