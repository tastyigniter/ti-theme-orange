<ul class="list-unstyled small">
    <?php foreach ($itemOptions as $itemOption) { ?>
        <li class="text-muted"><?= $itemOption->name; ?></li>
        <?php foreach ($itemOption->values as $optionValue) { ?>
            <li>
                <?php if ($optionValue->qty > 1) { ?>
                    <?= $optionValue->qty.' '.lang('igniter.cart::default.text_times'); ?>
                <?php } ?>
                <?= $optionValue->name; ?>&nbsp;
                <?php if ($optionValue->price > 0) { ?>
                    (<?= currency_format($optionValue->subtotal()); ?>)
                <?php } ?>
            </li>
        <?php } ?>
    <?php } ?>
</ul>
