<?php foreach ($optionValues as $optionIndex => $optionValue) { ?>
    <?php
    $menuOptionValueId = $optionValue->menu_option_value_id;
    $value = 0;
    if ($cartItem AND $cartItem->hasOptionValue($menuOptionValueId)){
        $cartItem->options->search(function ($option) use ($menuOptionValueId, &$value) {
            $option->values->each(function($opt) use ($menuOptionValueId, &$value) {
	           if ($opt->id == $menuOptionValueId){
		           $value = $opt->qty;
	           } 
            });
        });    
    }
    ?>
    <div
        class=""
    >
        <label
            class="w-100"
            for="menuOptionQuantity<?= $menuOptionValueId; ?>"
        >
            <?= $optionValue->name; ?>
            <span class="pull-right"><?= currency_format($optionValue->price); ?></span>
            <input
                type="hidden"
                name="menu_options[<?= $index; ?>][option_values][<?= $optionIndex; ?>][id]"
                value="<?= $optionValue->menu_option_value_id; ?>"
            />
	        <input
	            type="text"
	            class="pull-right w-25 mr-5"
	            id="menuOptionQuantity<?= $menuOptionValueId; ?>"
	            name="menu_options[<?= $index; ?>][option_values][<?= $optionIndex; ?>][qty]"
	            value="<?= $value; ?>"
	            data-option-price="<?= $optionValue->price; ?>"
	            inputmode="numeric"
	            pattern="[0-9]*"
	        />
        </label>
    </div>
<?php } ?>
