---
description: ''
---
<div class="col-sm-12">
    <div class="row">
        <div class="col-sm-4 mt-2">
            <h2 class="h5 pt-2 d-none d-sm-block">
                <?php if (count($locationsList) == 1) { ?>
                    <?= sprintf(lang('igniter.local::default.text_location_nearby'), count($locationsList)); ?>
                <?php } elseif (count($locationsList) > 1) { ?>
                    <?= sprintf(lang('igniter.local::default.text_locations_nearby'), count($locationsList)); ?>
                <?php } ?>
            </h2>
        </div>
        <div class="col-sm-4 mt-3">

        </div>
        <div class="col-sm-4 mt-2">

        </div>
    </div>
</div>
<?php foreach ($locationsList as $listItemlocation) { ?>
    <?php
    $categories = $listItemlocation->loadCategories();
    $location->setCurrent($listItemlocation);
    $openingSchedule = $listItemlocation->newWorkingSchedule('opening');
    $deliverySchedule = $listItemlocation->newWorkingSchedule('delivery');
    $collectionSchedule = $listItemlocation->newWorkingSchedule('collection');
    $hasDelivery = $listItemlocation->hasDelivery();
    $hasCollection = $listItemlocation->hasCollection();
    $distance = ($coordinates = $userPosition->getCoordinates())
        ? $listItemlocation->calculateDistance($coordinates) : null;
    $deliveryMinutes = $listItemlocation->deliveryMinutes();
    $collectionMinutes = $listItemlocation->collectionMinutes();
    $openingTime = Carbon\Carbon::parse($openingSchedule->getOpenTime());
    $collectionTime = Carbon\Carbon::parse($deliverySchedule->getOpenTime());
    $collectionTime = Carbon\Carbon::parse($collectionSchedule->getOpenTime());
    $reviewScore = $location->getReviewScore();
    $reviews_count = count($location->getModel()->reviews);
//    dd($reviews_count);
    $deliveryConditions = $location->getDeliveryConditions();
    $location->clearCoveredArea();
//    dd($listItemlocation);
    ?>

    <div class="card">
        <?php if ($listItemlocation->hasMedia('thumb')) { ?>
            <div class="card-img-top">
                <a href="<?= page_url('local/menus', ['listItemlocation' => $listItemlocation->permalink_slug]); ?>">
                    <img class="img-responsive img-fluid" style="height: 240px;"
                         href="<?= page_url('local/menus', ['listItemlocation' => $listItemlocation->permalink_slug]); ?>"
                         src="<?= $listItemlocation->getThumb([
                             'width' => 348,
                             'height' => 240,
                         ], 'thumb'); ?>">

                </a>
            </div>
        <?php } ?>
        <div class="card-body pb-0">
            <dl class="no-spacing h-100">
                <div class="row">
                    <a class="col-sm-12 mb-0 pb-0 smoova-store-name-link"
                       href="<?= page_url('local/menus', ['listItemlocation' => $listItemlocation->permalink_slug]); ?>">
                        <h5 class="card-title"
                            style="margin-bottom: 0px;line-height: 0.1;"><?= $listItemlocation->location_name; ?></h5>
                    </a>
                </div>

                <div class="row">
                    <?php if ($showReviews && $reviews_count > 0) { ?>
                        <div class="col-sm-12 mt-3">
                            <div data-control="star-rating"
                                 data-score="<?= $reviewScore ?>"
                                 data-score-name="Quality"
                                 data-read-only="true">
                                <div class="rating rating-star text-warning" style="display: inline-block;"></div>
                                <i class="text-muted" style="font-style: normal;"><?= $reviewScore ?>
                                    (<?= $reviews_count; ?>)</i>
                                <d class="smoova-text-xsmall ml-1"><?= $listItemlocation->price_range; ?></d>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="col-sm-12 text-muted smoova-text-small"
                             style="margin-top: 10px !important; margin-bottom: 3px;  color: #a2a2a2 !important;">
                            <?= lang('admin::lang.ratings.text_empty'); ?>
                            <d class="smoova-text-xsmall ml-1"><?= $listItemlocation->price_range; ?></d>
                        </div>
                    <?php } ?>


                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <dd class="text-muted mt-0">
                            <?php
                            $i = 0;
                            foreach ($categories as $category) { ?>
                                <?php
                                $i++;
                                if ($i < count($categories)) { ?>
                                    <?= $category->name . ', '; ?>
                                <?php } else { ?>
                                    <?= $category->name; ?>
                                <?php }
                            }
                            ?>
                        </dd>

                    </div>


                </div>


                <div class="row mt-0">
                    <div class="col-sm-8">
                        <?php if ($openingSchedule->isOpen()) { ?>
                        <?php } else if ($openingSchedule->isOpening()) { ?>
                            <dd class="text-muted mt-0">
                                <?= sprintf(lang('igniter.local::default.text_opening_time'), $openingTime->isoFormat($openingTimeFormat)); ?>
                            </dd>
                        <?php } else { ?>
                            <dd class="text-muted mt-0"><?= lang('igniter.local::default.text_closed'); ?></dd>
                        <?php } ?>
                    </div>
                    <div class="col-sm-4 pl-0">

                    </div>
                </div>


            </dl>
        </div>
        <div class="card-footer bg-transparent pt-0 mt-2 pb-1 mr-0">

            <?php
            if (!empty($deliveryConditions)) {
                ?>
                <div class="row mt-0">
                    <div class="col-sm-1 smoova-mobile-icon-col">
                        <img class="smoova-icon-m" src="/assets/media/uploads/icons/delivery.svg"/>
                    </div>
                    <div class="col-sm-10 pr-0 smoova-mobile-col-lg">
                        <dd class="text-body" style="margin-bottom: 2px; margin-top: 2px;">

                            <?= lang('admin::lang.locations.text_tab_delivery'); ?>
                            <?php
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
                        </dd>

                    </div>
                </div>
            <?php } ?>

            <div class="row mt-0 pb-1">
                <div class="col-sm-1 smoova-mobile-icon-col">
                    <dd class="text-muted ml-1 mt-2">
                        <i class="fa fa-map-marker text-muted"
                           style="color: #EC417D !important; font-size: 24px"></i>
                    </dd>
                </div>
                <div class="col-sm-5 smoova-mobile-col-md" >
                    <dd class="text-muted " style="margin-top: 9px !important;">
                        <?= ' ' . number_format($distance, 1); ?> <?= $distanceUnit; ?>
                    </dd>
                </div>
                <div class="col-sm-1 mr-3 smoova-mobile-icon-col">
                    <dd class="text-muted ml-1 mt-2 text-right pr-1">
                        <i class="far fa-clock align-middle text-right"
                           style="color: #5A9DD6;  font-size: 18px"></i>
                    </dd>
                </div>
                <div class="col-sm-4 px-0 smoova-mobile-col-sm" style="margin-top: 4px !important;">

                    <i class="text-muted smoova-font-default">

                        <?php if (($deliveryMinutes !== 0 && $collectionMinutes !== 0 && $deliveryMinutes !== $collectionMinutes)) { ?>
                            <dd class="text-muted text-left mr-0 my-0"><?= lang('admin::lang.locations.text_tab_delivery'); ?> <?= sprintf(lang('igniter.local::default.text_in_minutes'), $deliveryMinutes); ?></dd>
                            <dd class="text-muted text-left mr-0 my-0 py-0"><?= lang('igniter.cart::default.checkout.label_collection'); ?> <?= sprintf(lang('igniter.local::default.text_in_minutes'), $collectionMinutes); ?></dd>
                        <?php } elseif ($deliveryMinutes !== 0 and $collectionMinutes !== 0) { ?>
                            <dd class="text-muted text-left mr-0" style="margin-top: 6px;"><?= lang('admin::lang.locations.text_tab_delivery'); ?> <?= sprintf(lang('igniter.local::default.text_in_minutes'), $deliveryMinutes); ?></dd>
                        <?php } else if ($deliveryMinutes !== 0) { ?>
                            <dd class="text-muted text-left mr-0" style="margin-top: 6px;"><?= lang('admin::lang.locations.text_tab_delivery'); ?> <?= sprintf(lang('igniter.local::default.text_in_minutes'), $deliveryMinutes); ?></dd>
                        <?php } else if ($collectionMinutes !== 0) { ?>
                            <dd class="text-muted text-left mr-0" style="margin-top: 6px;"><?= lang('igniter.cart::default.checkout.label_collection'); ?> <?= sprintf(lang('igniter.local::default.text_in_minutes'), $collectionMinutes); ?></dd>
                        <?php } ?>

                    </i>
                </div>
            </div>
        </div>
    </div>
<?php } ?>