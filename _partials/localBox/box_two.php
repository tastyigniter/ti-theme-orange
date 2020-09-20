---
description: ''
---
<?php
$hasDelivery = $locationCurrent->hasDelivery();
$hasCollection = $location->current()->hasCollection();
$schedule = $location->workingSchedule($location->orderType());
$openingTime = Carbon\Carbon::parse($schedule->getOpenTime());
$closingTime = Carbon\Carbon::parse($schedule->getCloseTime());

?>
<div class="row">
    <div class="col-sm-12 pl-3">
        <?php if ($schedule->isOpen()) { ?>
            <img class="smoova-icon-xxl" style="margin-left: 165px;" src="/assets/media/uploads/icons/open.svg"/>
        <?php } else if ($schedule->isOpening()) { ?>
            <img class="smoova-icon-xxl pt-1" src="/assets/media/uploads/icons/closed.svg"/>
<!--            <span class="text-muted mr-2 mt-2 align-bottom pl-1"><= sprintf(lang('igniter.local::default.text_opening_time'), $openingTime->isoFormat($openingTimeFormat)); ?></span>-->
            <span class="mr-2 mt-2 align-bottom pl-1 text-close text-danger text-bottom"><?= lang('igniter.local::default.text_opening').' '. $openingTime->isoFormat($openingTimeFormat); ?></span>
        <?php } else { ?>
            <img class="smoova-icon-xxl" style="margin-left: 165px;" src="/assets/media/uploads/icons/closed.svg"/>
        <?php } ?>
    </div>
    <div class="col-sm-12 pt-1"></div>
    <div class="col-sm-12">
        <?php if ($openingTime->isToday() and $schedule->getPeriod($openingTime)->opensAllDay()) { ?>
            <!--            <span class="fa fa-clock text-muted"></span>&nbsp;&nbsp;-->
            <i class="far fa-clock text-muted pt-1"
               style="color: #407FC1 !important; font-size: 19px"></i>
            <span  class="pl-2"><?= lang('igniter.local::default.text_24_7_hour'); ?></span>
        <?php } else { ?>
            <i class="far fa-clock text-muted pt-1"
               style="color: #407FC1 !important; font-size: 19px"></i>
            <span class="pl-2">
                    <?= $openingTime->isoFormat($localBoxTimeFormat); ?>
                    -
                    <?= $closingTime->isoFormat($localBoxTimeFormat); ?>
                    </span>
        <?php } ?>
    </div>
    <div class="col-sm-12 pt-1"></div>
    <div class="col-sm-1 smoova-mobile-icon-col">
        <img class="smoova-icon-m" src="/assets/media/uploads/icons/delivery.svg"/>
    </div>
    <div class="col-sm-10 smoova-mobile-col-lg" style="margin-top: 2px;">
        <?= lang('admin::lang.locations.text_tab_delivery'); ?>
        <?php
        $deliveryConditions = $__SELF__->getAreaConditionLabels();
        $i = 0;
        foreach ($deliveryConditions as $deliveryCondition) {
            $i++;
            if ($i < count($deliveryConditions)) { ?>
                <?= $deliveryCondition . '; '; ?>
            <?php } else { ?>
                <?= $deliveryCondition; ?>
            <?php }
        }
        ?>
    </div>
    <?php if (
        $location->requiresUserPosition()
        and $location->userPosition()->hasCoordinates()
        and !$location->checkDeliveryCoverage()
    ) { ?>
        <div class="col-sm-12 pt-2">
            <span class="help-block"><?= lang('igniter.local::default.text_delivery_coverage'); ?></span>
        </div>
    <?php } ?>



</div>
