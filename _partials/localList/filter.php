<div class="card">
    <div class="card-header">
        <h5><?= lang('igniter.local::default.text_locations_filter_title') ?></h5>
    </div>
    <div class="list-group list-group-flush">
        <?php foreach ($filterSorters as $key => $filter) { ?>
            <a
                class="list-group-item<?= ($key == $filterSorted) ? ' disabled' : '' ?>"
                href="<?= $filter['href']; ?>"
            ><?= $filter['name']; ?></a>
        <?php } ?>
    </div>
</div>
