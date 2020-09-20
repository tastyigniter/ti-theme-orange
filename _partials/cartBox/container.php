---
description: ''
---
<!--<div class="<= (!$pageIsCart) ? 'affix-cart d-none d-sm-block' : ''; ?>">-->
    <div class="<?= (!$pageIsCart) ? 'd-none d-sm-block' : ''; ?>">
    <div class="panel panel-cart">
        <div class="panel-body">
            
            <div id="local-control" style="margin-bottom: 15px;">
                <?= partial('localBox::timeslot'); ?>
          	</div>
          	<div id="local-control">
                <?= partial('localBox::control'); ?>
            </div>

            <?= partial('cartBox::default'); ?>
        </div>
    </div>
</div>
<?= partial('cartBox::mobile'); ?>

