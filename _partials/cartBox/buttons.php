<?php $locationIsClosed = ($cartBox->locationIsClosed() OR $cartBox->hasMinimumOrder()); ?>
<button
    class="checkout-btn btn btn-primary <?= ($locationIsClosed) ? 'disabled' : ''; ?> btn-block btn-lg"
    data-attach-loading="disabled"
    <?php if ($pageIsCheckout AND !$locationIsClosed) { ?>
        data-checkout-control="confirm-checkout"
        data-request-form="#checkout-form"
    <?php } else if (!$locationIsClosed) { ?>
        data-request="<?= $checkoutEventHandler; ?>"
        data-request-data="locationId: '<?= $location->getId() ?>'"
    <?php } ?>
><?= $cartBox->buttonLabel(); ?></button>