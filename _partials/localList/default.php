<?php if (count($locationsList)) { ?>
    <div class="local-group">
        <?= partial('@list', [
            'locationsList' => $locationsList,
            'distanceUnit' => $distanceUnit,
        ]); ?>
    </div>

    <div class="pagination-bar text-right">
        <div class="links"><?= $locationsList->links(); ?></div>
    </div>
<?php }
else { ?>
    <div class="panel panel-local">
        <div class="panel-body">
            <p><?= lang('igniter.local::default.text_filter_no_match'); ?></p>
        </div>
    </div>
<?php } ?>
