<?php if (count($customerAddresses)) { ?>
    <div class="list-group list-group-flush mb-3">
        <?php $index = 0;
        foreach ($customerAddresses as $address) { ?>
            <?php $index++; ?>
            <div
                class="list-group-item <?= ($customer->address_id == $address->address_id) ? 'list-group-item-info' : ''; ?>"
            >
                <address class="text-left"><?= format_address($address); ?></address>
                <span class="">
                    <a
                        class="btn btn-outline-default"
                        href="<?= site_url('account/address', ['addressId' => $address->address_id]); ?>"
                    ><?= lang('igniter.user::default.account.text_edit'); ?></a>
                </span>
            </div>
        <?php } ?>
    </div>

    <div class="pagination-bar text-right">
        <div class="links"><?= $customerAddresses->links(); ?></div>
    </div>
<?php } else { ?>
    <p><?= lang('igniter.user::default.account.text_no_address'); ?></p>
<?php } ?>

<div class="buttons">
    <button
        class="btn btn-primary btn-lg"
        data-request="<?= $addAddressEventHandler; ?>"
    ><?= lang('igniter.user::default.account.button_add'); ?></button>
</div>
