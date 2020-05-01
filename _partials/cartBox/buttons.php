<?php $locationIsClosed = $cartBox->locationIsClosed(); ?>
<button
    class="checkout-btn btn btn-primary <?= ($locationIsClosed) ? 'disabled' : ''; ?> btn-block btn-lg"
    data-attach-loading="disabled"
    <?php if ($pageIsCheckout) { ?>
        data-checkout-control="confirm-checkout"
        data-request-form="#checkout-form"
    <?php } else if (!$locationIsClosed) { ?>
        data-request="<?= $checkoutEventHandler; ?>"
        data-request-data="locationId: '<?= $location->getId() ?>'"
    <?php } ?>
><?= $cartBox->buttonLabel(); ?></button>