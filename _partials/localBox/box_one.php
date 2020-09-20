---
description: ''
---
<!--<php if ($location->getModel()->hasMedia('logo')) { ?>-->
<!--    <img class="img-responsive img-fluid" style="height: 120px; width: 120px; border-radius: 4px;"-->
<!--         src="<= $location->getModel()->getThumb([-->
<!--             'width' => 120,-->
<!--             'height' => 120,-->
<!--         ], 'logo'); ?>">-->
<!--<php } ?>-->
<?php
if ($showLocalThumb) { ?>
    <img class="img-responsive pull-left"
         src="<?= $locationCurrent->getThumb(['width' => $localThumbWidth, 'height' => $localThumbHeight]); ?>">
<?php } ?>
<div class="row">
    <div class="col-sm-12 mb-0 pb-0">
        <h1 class="h3 mb-0 pb-0"><?= $locationCurrent->getName(); ?></h1>
    </div>
    <div class="col-sm-12 mb-0 ">
        <?php if ($showReviews && $location->getReviewScore() > 0) { ?>
            <div class="col-sm-12 mt-0 pt-0 pl-0 align-top">
                <div class="pt-0 mt-0 align-top"
                     data-control="star-rating"
                     data-score="<?= $location->getReviewScore(); ?>"
                     data-score-name="Quality"
                     data-read-only="true">
                    <div class="rating rating-star text-warning" style="display: inline-block;"></div>
                    <i class="text-muted" style="   font-style: normal;">
                        <?= $location->getReviewScore(); ?>
                        (<?= count($locationCurrent->reviews); ?>)
                        <d class="smoova-text-xsmall ml-1"><?= $locationCurrent->price_range; ?></d>
                    </i>
                </div>
            </div>
        <?php } else { ?>
            <div class="col-sm-12 text-muted"
                 style="margin-top: 10px !important; margin-bottom: 3px; font-weight: 600; color: #a2a2a2; padding-left: 0px;">
                <?= lang('admin::lang.ratings.text_empty'); ?>
                <d class="smoova-text-xsmall ml-1"><?= $locationCurrent->price_range; ?></d>
            </div>
        <?php } ?>
    </div>
    <!--    <div class="col-sm-12 p-0">-->
    <button class="col-sm-12 pt-1" id="address_map" type="button" data-toggle="modal" data-target="#myModal"
            data-lat='<?= $locationCurrent->location_lat; ?>'
            data-lng='<?= $locationCurrent->location_lng; ?>'
            style="visibility: hidden; height: 0px !important;"></button>
    <!--    </div>-->
    <div class="col-sm-1 smoova-mobile-icon-col" onclick="(function(){ document.getElementById('address_map').click(); }).call(this)"
         style="margin-top: 1px;">
        <i class="fa fa-map-marker text-muted"
           style="color: #EC417D !important; font-size: 20px"></i>
    </div>
    <div class="col-sm-11 pl-1 btn-link  smoova-mobile-col-lg"
         onclick="(function(){ document.getElementById('address_map').click(); }).call(this)">
        <?= format_address($locationCurrent->getAddress(), FALSE); ?>
    </div>

    <div class="col-sm-12 pt-1"></div>
    <div class="col-sm-1 smoova-mobile-icon-col">
        <img class="smoova-icon-s" src="/assets/media/uploads/icons/phone.svg"/>
    </div>
    <div class="col-sm-11 text-muted pl-1 smoova-mobile-col-lg" style="margin-top: 1px;">
        <a href="tel:<?= $locationCurrent->getTelephone(); ?>"><?= $locationCurrent->getTelephone(); ?></a>
    </div>
    <div class="col-sm-12 py-1"></div>
    <div class="col-sm-1 smoova-mobile-icon-col">
        <img class="smoova-icon-s" src="/assets/media/uploads/icons/email.svg"/>
    </div>
    <div class="col-sm-11 text-muted pl-1 smoova-mobile-col-lg" style="margin-top: 1px;">
        <a href="mailto:<?= $locationCurrent->location_email; ?>"><?= $locationCurrent->location_email; ?></a>
    </div>
    <?php if ($locationCurrent->website) { ?>
    <div class="col-sm-1 pt-2 smoova-mobile-icon-col">
        <i class="fas fa-globe" style="color: #5A9DD6 !important; font-size: 20px"></i>
    </div>
    <div class="col-sm-5 text-muted pl-1 pt-2 smoova-mobile-col-lg">
        <a href="<?= $locationCurrent->website; ?>" target="_blank"><?= $locationCurrent->website; ?></a>
    </div>
    <?php } ?>
    <div class="col-sm-6 py-0">
        <?php if ($locationCurrent->facebook) { ?>
            <a href="<?= $locationCurrent->facebook; ?>" target="_blank">
                <img class="smoova-icon-xxxl pt-0 mt-0 pl-4" src="/assets/media/uploads/icons/facebook.svg"/>
            </a>
        <?php } ?>
        <?php if ($locationCurrent->instagram) { ?>
            <a href="<?= $locationCurrent->instagram; ?>" target="_blank">
                <img class="smoova-icon-xxxl pt-0 mt-0 pl-4" src="/assets/media/uploads/icons/instagram.svg"/>
            </a>
        <?php } ?>
        <?php if ($locationCurrent->twitter) { ?>
            <a href="<?= $locationCurrent->twitter; ?>" target="_blank">
                <img class="smoova-icon-xxxl pt-0 mt-0 pl-4" src="/assets/media/uploads/icons/twitter.svg"/>
            </a>
        <?php } ?>
        <?php if ($locationCurrent->linkedin) { ?>
            <a href="<?= $locationCurrent->linkedin; ?>" target="_blank">
                <img class="smoova-icon-xxxl pt-0 mt-0 pl-4" src="/assets/media/uploads/icons/linkedin.svg"/>
            </a>
        <?php } ?>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel"><?= $locationCurrent->getName(); ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-0">
                <div class="row">
                    <div class="col-md-12 modal_body_map">
                        <div class="location-map" id="location-map">
                            <div style="width: 800px; height: 600px;" id="map_canvas"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function (event) {
        initGoogleMapLocation();
    });

</script>