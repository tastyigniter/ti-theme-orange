---
description: ''
---
<div class="col-sm-12 mt-3 ml-3">

    <div class="row mb-5">
        <h2 class="h5"><?= lang('admin::lang.menus.text_tab_menu_option') ?></h2>
        <div class="custom-control custom-checkbox smoova-category-item w-100">
<!--            <dd>-->
<!--                <input class="custom-control-input" type="checkbox" name="openNow"-->
<!--                       value="openNow" id="cbOpenNow"-->
<!--                    <php if (isset($_POST['openNow'])) { ?> checked<php } ?>-->
<!--                       onchange="(function(){ document.getElementById('locationListForm').submit(); }).call(this)">-->
<!--                <label class="custom-control-label"-->
<!--                       for="cbOpenNow"><= lang('igniter.local::default.text_filter_open_now'); ?>-->
<!--                </label>-->
<!--            </dd>-->
<!--            <dd>-->
<!--                <input class="custom-control-input" type="checkbox" name="freeDelivery"-->
<!--                       value="freeDelivery" id="cbFreeDelivery"-->
<!--                    <php if (isset($_POST['freeDelivery'])) { ?> checked<php } ?>-->
<!--                       onchange="(function(){ document.getElementById('locationListForm').submit(); }).call(this)">-->
<!--                <label class="custom-control-label"-->
<!--                       for="cbFreeDelivery"><= lang('igniter.local::default.text_filter_free_delivery'); ?>-->
<!--                </label>-->
<!--            </dd>-->

            <dd>
                <input class="custom-control-input" type="checkbox" name="hasPickup"
                       value="hasPickup" id="cbHasPickup"
                    <?php if (isset($_POST['hasPickup'])) { ?> checked<?php } ?>
                       onchange="(function(){ document.getElementById('locationListForm').submit(); }).call(this)">
                <label class="custom-control-label"
                       for="cbHasPickup"><?= lang('igniter.local::default.text_collection'); ?>
                </label>
            </dd>

            <dd>
                <input class="custom-control-input" type="checkbox" name="hasDelivery"
                       value="hasDelivery" id="cbHasDelivery"
                    <?php if (isset($_POST['hasDelivery'])) { ?> checked<?php } ?>
                       onchange="(function(){ document.getElementById('locationListForm').submit(); }).call(this)">
                <label class="custom-control-label"
                       for="cbHasDelivery"><?= lang('igniter.local::default.review.label_delivery'); ?>
                </label>
            </dd>

<!--            <dd>-->
<!--                <input class="custom-control-input" type="checkbox" name="topRated"-->
<!--                       value="topRated" id="cbTopRated"-->
<!--                    <php if (isset($_POST['topRated'])) { ?> checked<php } ?>-->
<!--                       onchange="(function(){ document.getElementById('locationListForm').submit(); }).call(this)">-->
<!--                <label class="custom-control-label"-->
<!--                       for="cbTopRated"><= lang(''); ?>Top Rated-->
<!--                </label>-->
<!--            </dd>-->
        </div>
    </div>

    <div class="row mt-5">
        <h2 class="h5 w-100"><?= lang('main::lang.media_manager.text_sort_by') ?></h2>
        <div class="option-group">
            <?php foreach ($filterSorters as $key => $filter) { ?>

                <div class="custom-control custom-radio smoova-category-item">
                    <input type="radio"
                           class="custom-control-input"
                           id="<?= 'filter_sort_id_' . $filter['name']; ?>"
                           name="sort_by"
                           value="<?= $filter['key']; ?>"
                           <?php if ($filterSorted == $filter['key']){ ?>checked<?php } ?>
                           onchange="(function(){ document.getElementById('locationListForm').submit(); }).call(this)"

                    >
                    <label class="custom-control-label w-100"
                           for="<?= 'filter_sort_id_' . $filter['name']; ?>">
                        <?= $filter['name']; ?>
                    </label>
                </div>
            <?php } ?>
        </div>
    </div>

</div>