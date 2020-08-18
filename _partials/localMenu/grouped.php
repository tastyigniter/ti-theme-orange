<div class="menu-group">
    <?php if (!count($groupedMenuItems)) { ?>
        <div class="menu-group-item">
            <p><?= lang('igniter.local::default.text_no_category'); ?></p>
        </div>
    <?php }
    else { ?>
        <?php $index = 0;
        foreach ($groupedMenuItems as $categoryId => $menuList) { ?>
            <?php
            $hasCategory = $categoryId > 0;
            $index++;
            ?>
            <div class="menu-group-item">
                <?php if ($hasCategory) {
                    $menuCategory = array_get($menuListCategories, $categoryId);
                    $menuCategoryAlias = strtolower(str_slug($menuCategory->name));
                    ?>
                    <div id="category-<?= $menuCategoryAlias; ?>-heading" role="tab">
                        <h4
                            class="category-title cursor-pointer"
                            data-toggle="collapse"
                            data-target="#category-<?= $menuCategoryAlias; ?>-collapse"
                            aria-expanded="false"
                            aria-controls="category-<?= $menuCategoryAlias; ?>-heading"
                        ><?= e($menuCategory->name); ?><span class="collapse-toggle text-muted pull-right"></span></h4>
                    </div>
                    <div
                        id="category-<?= $menuCategoryAlias; ?>-collapse"
                        class="collapse <?= $index < 5 ? 'show' : ''; ?>"
                        role="tabpanel" aria-labelledby="<?= $menuCategoryAlias; ?>"
                    >
                        <div class="menu-category">
                            <?php if (strlen($menuCategory->description)) { ?>
                                <p><?= nl2br($menuCategory->description); ?></p>
                            <?php } ?>

                            <?php if ($menuCategory->hasMedia('thumb')) { ?>
                                <div class="image">
                                    <img
                                        class="img-responsive"
                                        src="<?= $menuCategory->getThumb([
                                            'width' => $menuCategoryWidth,
                                            'height' => $menuCategoryHeight,
                                        ]); ?>"
                                        alt="<?= $menuCategory->name; ?>"/>
                                </div>
                            <?php } ?>
                        </div>

                        <?= partial('@items', ['menuItems' => $menuList]); ?>
                    </div>
                <?php } else { ?>
                    <?= partial('@items', ['menuItems' => $menuList]); ?>
                <?php } ?>
            </div>
        <?php } ?>
    <?php } ?>
</div>