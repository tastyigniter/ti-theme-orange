<?php if ($cart->count()) { ?>
    <form
        id="tip-form"
        method="POST"
        role="form"
        data-request="<?= $applyTipEventHandler; ?>"
    >
        <div class="cart-tip">
	        
	        <?php 
		        $tipPercentages = config('cart.tipPercentages');      
		        if (sizeof($tipPercentages) > 0) {      
		    ?>
			<div class="btn-group btn-group-toggle w-100 text-center tip-percentage" data-toggle="buttons">
				<?php foreach ($tipPercentages as $tipPercentage){ ?>
                <label class="btn btn-light active">
                	<input type="radio" name="tip_percentage" data-cart-control="tip-percentage" value="<?= str_replace('%', '', $tipPercentage['amount']); ?>%">&nbsp;&nbsp;
					<strong><?= $tipPercentage['label']; ?></strong>
				</label>
				<?php } ?>
            </div>	 
            <?php } ?>       
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