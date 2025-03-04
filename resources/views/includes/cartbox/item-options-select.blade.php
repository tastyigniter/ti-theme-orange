<select
    x-on:change="calculateTotal()"
    wire:model="menuOptions.{{ $menuOption->menu_option_id }}.option_values.0"
    name="menuOptions[{{ $menuOption->menu_option_id }}][option_values][]"
    class="form-select"
>
    <option>@lang('admin::lang.text_select')</option>
    @foreach ($optionValues->sortBy('priority') as $optionValue)
        @php $isSelected = ($cartItem && $cartItem->hasOptionValue($optionValue->menu_option_value_id)); @endphp
        <option
            value="{{ $optionValue->menu_option_value_id }}"
            @selected(($cartItem && $cartItem->hasOptionValue($optionValue->menu_option_value_id)) || $optionValue->isDefault())
            data-option-price="{{ $optionValue->price }}"
        >{{ $optionValue->name }}{!! ($optionValue->price > 0 || !$hideZeroOptionPrices ? '&nbsp;&nbsp;-&nbsp;&nbsp;'.lang('igniter::main.text_plus').currency_format($optionValue->price) : '') !!}</option>
    @endforeach
</select>
