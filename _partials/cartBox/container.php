<div class="<?= (!$pageIsCart) ? 'affix-cart d-none d-sm-block' : ''; ?>">
    <div class="panel panel-cart">
        <div class="panel-body">
            <div id="local-control">
                <?= partial('localBox::control'); ?>
            </div>

            <?= partial('cartBox::default'); ?>
        </div>
    </div>
</div>
<?= partial('cartBox::mobile'); ?>