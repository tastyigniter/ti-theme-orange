<?php if (count($localHours)) { ?>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
            <tr>
                <th></th>
                <th><?= lang('igniter.local::default.text_opening'); ?></th>
                <th><?= lang('igniter.local::default.text_delivery'); ?></th>
                <th><?= lang('igniter.local::default.text_collection'); ?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($localHours as $day => $hours) { ?>
                <tr>
                    <td><?= $day; ?></td>
                    <?php foreach ($hours->sortByDesc('type') as $hour) { ?>
                        <?php if ($hour->type == 'delivery' AND !$locationCurrent->hasDelivery()) { ?>
                            <td><?= lang('igniter.local::default.text_closed'); ?></td>
                        <?php } else if ($hour->type == 'collection' AND !$locationCurrent->hasCollection()) { ?>
                            <td><?= lang('igniter.local::default.text_closed'); ?></td>
                        <?php } else if (!$hour->isEnabled()) { ?>
                            <td><?= lang('igniter.local::default.text_closed'); ?></td>
                        <?php } else if ($hour->isOpenAllDay()) { ?>
                            <td><?= lang('igniter.local::default.text_24h'); ?></td>
                        <?php } else { ?>
                            <td><?= sprintf(
                                    lang('igniter.local::default.text_working_hour'),
                                    $hour->open->isoFormat($infoTimeFormat),
                                    $hour->close->isoFormat($infoTimeFormat)
                                ); ?></td>
                        <?php } ?>
                    <?php } ?>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
<?php } ?>
