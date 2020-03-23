<div
    data-control="checkout"
    data-choose-payment-handler="<?= $choosePaymentEventHandler; ?>"
    data-partial="checkoutForm"
>
    <?= partial('checkout::form'); ?>
</div>