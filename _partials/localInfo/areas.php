<?php if ($locationCurrent->hasDelivery()) { ?>
    <h4 class="panel-title p-3"><b><?= lang('igniter.local::default.text_delivery_areas'); ?></b></h4>
    <div class="list-group list-group-flush">
        <?php if (count($deliveryAreas)) { ?>
            <div class="list-group-item">
                <div class="row">
                    <div class="col-sm-4"><b><?= lang('admin::lang.label_name'); ?></b></div>
                    <div class="col-sm-8"><b><?= lang('igniter.local::default.column_area_charge'); ?></b>
                    </div>
                </div>
            </div>
            <?php foreach ($deliveryAreas as $key => $area) { ?>
                <div class="list-group-item">
                    <div class="row">
                        <div class="col-sm-4"><?= $area->name; ?></div>
                        <div class="col-sm-8">
                            <?= implode('<br>', $__SELF__->getAreaConditionLabels($area)); ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php }
        else { ?>
            <div class="list-group-item">
                <p><?= lang('igniter.local::default.text_no_delivery_areas'); ?></p>
            </div>
        <?php } ?>
    </div>
<?php } ?>
