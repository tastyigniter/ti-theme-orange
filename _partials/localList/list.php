<?php foreach ($locationsList as $location) { ?>
    <?php
    $openingSchedule = $location->newWorkingSchedule('opening');
    $deliverySchedule = $location->newWorkingSchedule('delivery');
    $collectionSchedule = $location->newWorkingSchedule('collection');
    $hasDelivery = $location->hasDelivery();
    $hasCollection = $location->hasCollection();
    $distance = ($coordinates = $userPosition->getCoordinates())
        ? $location->calculateDistance($coordinates) : null;
    $deliveryMinutes = $location->deliveryMinutes();
    $collectionMinutes = $location->collectionMinutes();
    $openingTime = Carbon\Carbon::parse($openingSchedule->getOpenTime());
    $collectionTime = Carbon\Carbon::parse($deliverySchedule->getOpenTime());
    $collectionTime = Carbon\Carbon::parse($collectionSchedule->getOpenTime());
    ?>
    <a
        class="card w-100 p-3 mb-2"
        href="<?= page_url('local/menus', ['location' => $location->permalink_slug]); ?>"
    >
        <div class="boxes d-sm-flex no-gutters">
            <div class="col-12 col-sm-7">
                <div class="d-sm-flex">
                    <?php if ($location->hasMedia('thumb')) { ?>
                        <div class="col-sm-3 p-0 mr-sm-4 mb-3 mb-sm-0">
                            <img class="img-responsive img-fluid"
                                 src="<?= $location->getThumb(); ?>">
                        </div>
                    <?php } ?>
                    <dl class="no-spacing">
                        <dd><h2 class="h5 mb-0 text-body"><?= $location->location_name; ?></h2></dd>
                        <?php if ($showReviews) { ?>
                            <dd>
                                <div class="rating rating-sm text-muted">
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star-half-o"></span>
                                    <span class="fa fa-star-o"></span>
                                    <span><?= sprintf(lang('igniter.local::default.review.text_total_review'), $location->reviews_count); ?></span>
                                </div>
                            </dd>
                        <?php } ?>
                        <dd class="d-none">
                        <span
                            class="text-muted text-truncate"><?= format_address($location->getAddress()); ?></span>
                        </dd>
                        <?php if ($distance) { ?>
                            <dd>
                            <span
                                class="text-muted small"
                            ><i class="fa fa-map-marker"></i>&nbsp;&nbsp;<?= number_format($distance, 1); ?> <?= $distanceUnit; ?></span>
                            </dd>
                        <?php } ?>
                    </dl>
                </div>
            </div>
            <div class="col-12 col-sm-5">
                <dl class="no-spacing">
                    <?php if ($openingSchedule->isOpen()) { ?>
                        <dt><?= lang('igniter.local::default.text_is_opened'); ?></dt>
                    <?php }
                    else if ($openingSchedule->isOpening()) { ?>
                        <dt class="text-muted"><?= sprintf(lang('igniter.local::default.text_opening_time'), $openingTime->isoFormat($openingTimeFormat)); ?></dt>
                    <?php }
                    else { ?>
                        <dt class="text-muted"><?= lang('igniter.local::default.text_closed'); ?></dt>
                    <?php } ?>
                    <dd class="text-muted">
                        <?php if ($hasDelivery) { ?>
                            <?php if ($deliverySchedule->isOpen()) { ?>
                                <?= sprintf(lang('igniter.local::default.text_delivery_time_info'), sprintf(lang('igniter.local::default.text_in_minutes'), $deliveryMinutes)); ?>
                            <?php }
                            else if ($deliverySchedule->isOpening()) { ?>
                                <?= sprintf(lang('igniter.local::default.text_delivery_time_info'), sprintf(lang('igniter.local::default.text_starts'), $collectionTime->isoFormat($openingTimeFormat))); ?>
                            <?php }
                            else { ?>
                                <?= sprintf(lang('igniter.local::default.text_delivery_time_info'), lang('igniter.local::default.text_is_closed')); ?>
                            <?php } ?>
                        <?php } ?>
                    </dd>
                    <dd class="text-muted">
                        <?php if ($hasCollection) { ?>
                            <?php if ($collectionSchedule->isOpen()) { ?>
                                <?= sprintf(lang('igniter.local::default.text_collection_time_info'), sprintf(lang('igniter.local::default.text_in_minutes'), $collectionMinutes)); ?>
                            <?php }
                            else if ($collectionSchedule->isOpening()) { ?>
                                <?= sprintf(lang('igniter.local::default.text_collection_time_info'), sprintf(lang('igniter.local::default.text_starts'), $collectionTime->isoFormat($openingTimeFormat))); ?>
                            <?php }
                            else { ?>
                                <?= sprintf(lang('igniter.local::default.text_collection_time_info'), lang('igniter.local::default.text_is_closed')); ?>
                            <?php } ?>
                        <?php } ?>
                    </dd>
                    <dd class="text-muted small">
                        <?php if (!$hasDelivery AND $hasCollection) { ?>
                            <?= lang('igniter.local::default.text_only_collection_is_available'); ?>
                        <?php }
                        else if ($hasDelivery AND !$hasCollection) { ?>
                            <?= lang('igniter.local::default.text_only_delivery_is_available'); ?>
                        <?php }
                        else if ($hasDelivery AND $hasCollection) { ?>
                            <?= lang('igniter.local::default.text_offers_both_types'); ?>
                        <?php }
                        else { ?>
                            <?= lang('igniter.local::default.text_offers_no_types'); ?>
                        <?php } ?>
                    </dd>
                </dl>
            </div>
        </div>
    </a>
<?php } ?>