<?php if ($showLocalThumb) { ?>
    <img class="img-responsive pull-left"
         src="<?= $locationCurrent->getThumb(['width' => $localThumbWidth, 'height' => $localThumbHeight]); ?>">
<?php } ?>
<dl class="no-spacing">
    <dd><h1 class="h3"><?= $locationCurrent->getName(); ?></h1></dd>
    <?php if ($showReviews) { ?>
        <dd class="text-muted">
            <div class="rating rating-sm">
                <span class="fa fa-star"></span>
                <span class="fa fa-star"></span>
                <span class="fa fa-star"></span>
                <span class="fa fa-star-half-o"></span>
                <span class="fa fa-star-o"></span>
                <span
                    class="small"><?= sprintf(lang('igniter.local::default.review.text_total_review'), $locationCurrent->reviews_count); ?></span>
            </div>
        </dd>
    <?php } ?>
    <dd>
        <span class="text-muted"><?= format_address($locationCurrent->getAddress(), FALSE); ?></span>
    </dd>
</dl>