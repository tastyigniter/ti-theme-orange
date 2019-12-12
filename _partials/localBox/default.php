<div id="local-box">
    <div class="panel local-search">
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-<?= ($hideSearch) ? '12' : '4' ?> mb-3 mb-sm-0">
                    <div
                        id="local-timeslot"
                        data-control="timepicker"
                        data-time-slot="<?= e(json_encode($locationTimeslot)); ?>"
                    >
                        <?= partial('@timeslot'); ?>
                    </div>
                </div>
                <?php if (!$hideSearch) { ?>
                    <div class="col-sm-8">
                        <?= partial('@searchbar'); ?>
                    </div>
                <?php } ?>
            </div>
            <?php if (
                $location->requiresUserPosition()
                AND $location->userPosition()->hasCoordinates()
                AND !$location->checkDeliveryCoverage()
            ) { ?>
                <span class="help-block"><?= lang('igniter.local::default.text_delivery_coverage'); ?></span>
            <?php } ?>
        </div>
    </div>

    <?php if ($location->current()) { ?>
        <div class="panel panel-local">
            <div class="panel-body">
                <div class="row boxes">
                    <div class="box-one col-sm-6">
                        <?= partial('@box_one'); ?>
                    </div>
                    <div class="box-divider d-block d-sm-none"></div>
                    <div class="box-two col-sm-6">
                        <?= partial('@box_two'); ?>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</div>
