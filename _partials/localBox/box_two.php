<?php
$hasDelivery = $locationCurrent->hasDelivery();
$hasCollection = $location->current()->hasCollection();
$schedule = $location->workingSchedule($location->orderType());
$openingTime = Carbon\Carbon::parse($schedule->getOpenTime());
$closingTime = Carbon\Carbon::parse($schedule->getCloseTime());
?>
<dl class="no-spacing">
    <?php if ($schedule->isOpen()) { ?>
        <dt><?= lang('igniter.local::default.text_is_opened'); ?></dt>
    <?php }
    else if ($schedule->isOpening()) { ?>
        <dt class="text-muted"><?= sprintf(lang('igniter.local::default.text_opening_time'), $openingTime->isoFormat($openingTimeFormat)); ?></dt>
    <?php }
    else { ?>
        <dt class="text-muted"><?= lang('igniter.local::default.text_closed'); ?></dt>
    <?php } ?>

    <dd>
        <?php if ($openingTime->isToday() AND $schedule->getPeriod($openingTime)->opensAllDay()) { ?>
            <span class="fa fa-clock"></span>&nbsp;&nbsp;
            <span><?= lang('igniter.local::default.text_24_7_hour'); ?></span>
        <?php }
        else { ?>
            <span class="fa fa-clock-o"></span>&nbsp;
            <span>
                <?= $openingTime->isoFormat($localBoxTimeFormat); ?>
                -
                <?= $closingTime->isoFormat($localBoxTimeFormat); ?>
                </span>
        <?php } ?>
    </dd>

    <dd class="text-muted">
        <?php if (!$hasDelivery AND $hasCollection) { ?>
            <?= lang('igniter.local::default.text_collection_only'); ?>
        <?php }
        else if ($hasDelivery AND !$hasCollection) { ?>
            <?= lang('igniter.local::default.text_delivery_only'); ?>
        <?php }
        else if ($hasDelivery AND $hasCollection) { ?>
            <?= lang('igniter.local::default.text_both_types'); ?>
        <?php }
        else { ?>
            <?= lang('igniter.local::default.text_no_types'); ?>
        <?php } ?>
    </dd>
    <dd class="text-muted">
        <?= implode(', ', $__SELF__->getAreaConditionLabels()); ?>
    </dd>
</dl>
