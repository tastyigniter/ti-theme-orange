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
        class="custom-control custom-quantity"
    >
        <label
            class="custom-quantity-label w-100"
            for="menuOptionQuantity<?= $menuOptionValueId; ?>"
        >
            <?= $optionValue->name; ?>
            <?php if ($optionValue->price > 0 || !$hideZeroOptionPrices) {?>
                <span class="pull-right"><?= lang('main::lang.text_plus').currency_format($optionValue->price); ?></span>
            <?php } ?>
            <input
                type="hidden"
                name="menu_options[<?= $index; ?>][option_values][<?= $optionIndex; ?>][id]"
                value="<?= $optionValue->menu_option_value_id; ?>"
            />
	        <input
	            type="number"
	            class="form-control custom-quantity-input"
	            id="menuOptionQuantity<?= $menuOptionValueId; ?>"
	            name="menu_options[<?= $index; ?>][option_values][<?= $optionIndex; ?>][qty]"
	            value="<?= $value; ?>"
	            data-option-price="<?= $optionValue->price; ?>"
	            inputmode="numeric"
	            pattern="[0-9]*"
                min="0"
                autocomplete="off"
	        />
        </label>
    </div>
<?php } ?>
