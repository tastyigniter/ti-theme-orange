<?php foreach ($optionValues as $optionValue) { ?>
    <?php
    $optionIndex = $optionValue->menu_option_value_id;
    $value = 0;
    if ($cartItem AND $cartItem->hasOptionValue($optionIndex)){
        $cartItem->options->search(function ($option) use ($optionIndex, &$value) {
            $option->values->each(function($opt) use ($optionIndex, &$value) {
	           if ($opt->id == $optionIndex){
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
            for="menuOptionQuantity<?= $optionIndex; ?>"
        >
            <?= $optionValue->name; ?>
            <span class="pull-right"><?= currency_format($optionValue->price); ?></span>
	        <input
	            type="text"
	            class="pull-right w-25 mr-5"
	            id="menuOptionQuantity<?= $optionIndex; ?>"
	            name="menu_options[<?= $index; ?>][option_values][quantities][<?= $optionValue->menu_option_value_id; ?>]"
	            value="<?= $value; ?>"
	            data-option-price="<?= $optionValue->price; ?>"
	            inputmode="numeric"
	            pattern="[0-9]*"
	        >
        </label>
    </div>
<?php } ?>
