<div class="panel">
    <?php if ('' !== ($description = $locationCurrent->getDescription())) { ?>
        <div class="panel-body">
            <h1
                class="h4 wrap-bottom border-bottom"
            ><?= sprintf(lang('igniter.local::default.text_info_heading'), $locationCurrent->getName()); ?></h1>
            <p class="m-0"><?= nl2br($description); ?></p>
        </div>
    <?php } ?>

    <div class="list-group list-group-flush">
        <?php if ($openingType = $locationCurrent->workingHourType('opening') AND $openingType == '24_7') { ?>
            <div class="list-group-item"><?= lang('igniter.local::default.text_opens_24_7'); ?></div>
        <?php } ?>
        <?php if ($locationCurrent->hasDelivery()) { ?>
            <div class="list-group-item">
                <?= lang('igniter.local::default.text_delivery'); ?>
                <?php if ($location->deliverySchedule()->isOpen()) { ?>
                    <?= sprintf(lang('igniter.local::default.text_in_minutes'), $locationCurrent->deliveryMinutes()); ?>
                <?php } else if ($location->deliverySchedule()->isOpening()) { ?>
                    <?= sprintf(lang('igniter.local::default.text_starts'), $location->deliverySchedule()->getOpenTime('H:i a')); ?>
                <?php } else { ?>
                    <?= lang('igniter.local::default.text_closed'); ?>
                <?php } ?>
            </div>
        <?php } ?>
        <?php if ($locationCurrent->hasCollection()) { ?>
            <div class="list-group-item">
                <?= lang('igniter.local::default.text_collection'); ?>
                <?php if ($location->collectionSchedule()->isOpen()) { ?>
                    <?= sprintf(lang('igniter.local::default.text_in_minutes'), $locationCurrent->collectionMinutes()); ?>
                <?php } else if ($location->collectionSchedule()->isOpening()) { ?>
                    <?= sprintf(lang('igniter.local::default.text_starts'), $location->collectionSchedule()->getOpenTime('H:i a')); ?>
                <?php } else { ?>
                    <?= lang('igniter.local::default.text_closed'); ?>
                <?php } ?>
            </div>
        <?php } ?>
        <?php if ($locationCurrent->hasDelivery()) { ?>
            <div class="list-group-item">
                <?= lang('igniter.local::default.text_last_order_time'); ?>&nbsp;
                <?= $location->lastOrderTime()->isoFormat($lastOrderTimeFormat); ?>
            </div>
        <?php } ?>
        <?php if ($localPayments->isNotEmpty()) { ?>
            <div class="list-group-item">
                <i class="fa fa-paypal fa-fw"></i>&nbsp;<b><?= lang('igniter.local::default.text_payments'); ?></b><br/>
                <?= implode(', ', $localPayments->pluck('name')->all()); ?>.
            </div>
        <?php } ?>
    </div>

    <?= partial('@areas') ?>

    <h4 class="panel-title p-3"><b><?= lang('igniter.local::default.text_hours'); ?></b></h4>
    <?= partial('@hours') ?>
</div>

