---
description: ''
---
<?php
$mealtimes = $menuItem->mealtimes;
$special = $menuItem->special;
$mealtimeNotAvailable = !$menuItem->isAvailable($location->orderDateTime());
$specialActive = ($special and $special->active());
$menuHasOptions = $menuItem->hasOptions();
$menuPrice = $specialActive ? $special->getMenuPrice($menuItem->menu_price) : $menuItem->menu_price;
$mealtimeTitles = [];
foreach ($menuItem->mealtimes ?? [] as $mealtime) {
    $mealtimeTitles[] = sprintf(lang('igniter.local::default.text_mealtime'),
        $mealtime->mealtime_name, $mealtime->start_time, $mealtime->end_time
    );
}
?>
<div class="card smoova-card-small">
    <?php if ($showMenuImages == 1 and $menuItem->hasMedia('thumb')) { ?>
        <div class="card-img-top">
            <img
                 data-cart-control="load-item"
                 data-menu-id="<?= $menuItem->menu_id; ?>"
                 data-quantity="<?= $menuItem->minimum_qty; ?>"
                 class="img-responsive img-fluid img-rounded align-top"
                 style="height: 240px;"
                 alt="<?= $menuItem->menu_name; ?>"

                 src="<?= $menuItem->getThumb([
                     'width' => $menuImageWidth,
                     'height' => $menuImageHeight,
                 ]); ?>">
        </div>
    <?php } ?>
    <div class="card-body pb-0">
        <dl class="no-spacing h-100">
            <div class="row px-3">
                <h6 data-cart-control="load-item"
                    data-menu-id="<?= $menuItem->menu_id; ?>"
                    data-quantity="<?= $menuItem->minimum_qty; ?>"
                    class="menu-name smoova-text-medium"><?= e($menuItem->menu_name); ?>
                </h6>

            </div>
            <div class="row px-3">
                <p class="menu-desc text-muted mb-0" data-cart-control="load-item"
                   data-menu-id="<?= $menuItem->menu_id; ?>">
                    <?= nl2br($menuItem->menu_description); ?>
                </p>
            </div>
        </dl>
    </div>

    <div class="card-footer bg-transparent">
        <div class="row">
            <div class="col-sm-6">
                <dd class="text-muted">
                    <?php if ($specialActive and ($specialDaysRemaining = $special->daysRemaining()) > 0) { ?>
                        <?php
                        $specialDaysText = sprintf(lang('igniter.local::default.text_end_elapsed'), $specialDaysRemaining);
                        ?>
                        <span class="menu-meta text-muted">
                            <img class="smoova-icon-m" src="/assets/media/uploads/icons/special.svg" title="<?= $specialDaysText; ?>"/>
<!--                                <i class="fa fa-star text-warning pr-sm-1" title="<= $specialDaysText; ?>"></i>-->
                        </span>
                    <?php } ?>
                    <b><?= $menuPrice > 0 ? currency_format($menuPrice) : lang('main::lang.text_free'); ?></b>
                </dd>
            </div>
            <div class="col-sm-6">
                <dd class="text-muted text-right mt-0">
                    <!--                <span class="menu-button">-->
                    <button
                            class="btn btn-light btn-sm btn-cart<?= $mealtimeNotAvailable ? ' disabled' : '' ?> smoova-add-item-button"
                        <?php if (!$mealtimeNotAvailable) { ?>
                            <?php if ($menuHasOptions) { ?>
                                data-cart-control="load-item"
                                data-menu-id="<?= $menuItem->menu_id; ?>"
                                data-quantity="<?= $menuItem->minimum_qty; ?>"
                            <?php } else { ?>
                                data-request="<?= $updateCartItemEventHandler; ?>"
                                data-request-data="menuId: '<?= $menuItem->menu_id; ?>', quantity: '<?= $menuItem->minimum_qty; ?>'"
                                data-replace-loading="fa fa-spinner fa-spin"
                            <?php } ?>
                        <?php } else { ?>
                            title="<?= implode("\r\n", $mealtimeTitles); ?>"
                        <?php } ?>
                    >
                        <i class="fa fa-<?= $mealtimeNotAvailable ? 'clock-o' : 'plus' ?>"></i>
                    </button>
                    <!--            </span>-->
                </dd>
            </div>
        </div>
    </div>
</div>





