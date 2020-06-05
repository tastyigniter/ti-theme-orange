<?php if ($cart->count()) { ?>
    <form
        id="tip-form"
        method="POST"
        role="form"
        data-request="<?= $applyTipEventHandler; ?>"
    >
        <div class="cart-tip">
			<div class="btn-group btn-group-toggle w-100 text-center tip-percentage" data-toggle="buttons">
                <label class="btn btn-light active">
                	<input type="radio" name="tip_percentage" data-cart-control="tip-percentage" value="10%">&nbsp;&nbsp;
					<strong>10%</strong>
				</label>
                <label class="btn btn-light active">
                	<input type="radio" name="tip_percentage" data-cart-control="tip-percentage" value="15%">&nbsp;&nbsp;
					<strong>15%</strong>
				</label>				
                <label class="btn btn-light active">
                	<input type="radio" name="tip_percentage" data-cart-control="tip-percentage" value="20%">&nbsp;&nbsp;
					<strong>20%</strong>
				</label>
            </div>	        
            <div
                class="input-group">
                <input
                    type="text"
                    name="tip_amount"
                    class="form-control"
                    value="<?= ($tip = $cart->getCondition('tip')) ? $tip->getMetaData('amount') : '' ?>"
                    placeholder="<?= lang('igniter.cart::default.text_apply_tip'); ?>"
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