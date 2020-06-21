<?php if ($cart->count()) { ?>
    <form
        id="tip-form"
        method="POST"
        role="form"
        data-request="<?= $applyTipEventHandler; ?>"
    >
        <div class="cart-tip">
            <?php
            $tip = $cart->getCondition('tip');
            $tipAmountType = $tip ? $tip->getMetaData('amountType', 'none') : 'none';
            $currentAmount = $tip ? $tip->getMetaData('amount', 0) : '';
            ?>
            <?php if ($tipAmounts = $__SELF__->tippingAmounts()) { ?>
                <div class="btn-group btn-group-toggle w-100 text-center tip-amounts" data-toggle="buttons">
                    <button
                        type="button"
                        class="btn btn-light<?= ($tipAmountType == 'none') ? ' active' : ''; ?>"
                        data-cart-control="tip-amount"
                        data-tip-amount-type="none"
                    ><?= lang('igniter.cart::default.text_no_tip'); ?></button>
                    <?php foreach ($tipAmounts as $tipAmount) { ?>
                        <button
                            type="button"
                            class="btn btn-light<?= $currentAmount == $tipAmount->value ? ' active' : ''; ?>"
                            data-cart-control="tip-amount"
                            data-tip-amount-type="amount"
                            data-tip-value="<?= $tipAmount->value; ?>"
                        ><strong><?= $tipAmount->valueType != 'F' ? round($tipAmount->value).'%' : currency_format($tipAmount->value); ?></strong></button>
                    <?php } ?>
                    <button
                        type="button"
                        class="btn btn-light<?= ($tipAmountType == 'custom') ? ' active' : ''; ?>"
                        data-cart-control="tip-amount"
                        data-tip-amount-type="custom"
                    ><?= lang('igniter.cart::default.text_edit_tip'); ?></button>
                </div>
            <?php } ?>
            <input type="hidden" name="amount_type" value="<?= $tipAmountType; ?>">
            <div
                class="input-group<?= $tipAmounts ? ' mt-2' : '' ?>"
                data-tip-custom
                <?= ($tipAmounts AND $tipAmountType != 'custom') ? 'style="display: none;"' : '' ?>
            >
                <input
                    type="number"
                    name="amount"
                    class="form-control"
                    value="<?= $currentAmount; ?>"
                    placeholder="<?= lang('igniter.cart::default.text_apply_tip'); ?>"
                />
                <div class="input-group-append">
                    <button
                        type="submit"
                        class="btn btn-light"
                        data-replace-loading="fa fa-spinner fa-spin"
                        title="<?= lang('igniter.cart::default.button_apply_tip'); ?>"
                    ><i class="fa fa-check"></i></button>
                </div>
            </div>
        </div>
    </form>
<?php } ?>