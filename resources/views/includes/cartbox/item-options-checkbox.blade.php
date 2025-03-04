@foreach ($optionValues->sortBy('priority') as $optionValue)
    <div @class(['form-check', 'py-1' => !$loop->first || !$loop->last])>
        <input
            x-on:change="calculateTotal()"
            wire:model.fill="menuOptions.{{ $menuOption->menu_option_id }}.option_values.{{$optionValue->menu_option_value_id}}"
            type="checkbox"
            class="form-check-input"
            id="menuOptionCheck{{ $menuOptionValueId = $optionValue->menu_option_value_id }}"
            name="menuOptions[{{ $menuOption->menu_option_id }}][option_values][{{$optionValue->menu_option_value_id}}]"
            data-option-price="{{ $optionValue->price }}"
            @checked(($cartItem && $cartItem->hasOptionValue($menuOptionValueId)) || $optionValue->isDefault())
        >

        <label
            class="form-check-label ps-2 w-100"
            for="menuOptionCheck{{ $menuOptionValueId }}"
        >
            {!! $optionValue->name !!}
            @if ($optionValue->price > 0 || !$hideZeroOptionPrices)
                <span class="float-end fw-light">@lang('igniter::main.text_plus'){{ currency_format($optionValue->price) }}</span>
            @endif
        </label>
    </div>
@endforeach
