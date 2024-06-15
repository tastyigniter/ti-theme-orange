@foreach ($menuItemData->getOptions() as $index => $menuOption)
    <div
        x-data="OrangeCartItemOptions({{ $menuOption->min_selected }}, {{ $menuOption->max_selected }})"
        class="menu-option mb-3"
        data-control="item-option"
        data-option-type="{{ $menuOption->display_type }}"
    >
        <div class="option option-{{ $menuOption->display_type }}">
            <div class="option-details">
                <h5>
                    {{ $menuOption->option_name }}
                    @if ($menuOption->isRequired())
                        <span
                            class="fs-6 pull-right text-muted">@lang('igniter.cart::default.text_required')</span>
                    @endif
                </h5>
                @if ($menuOption->min_selected > 0 || $menuOption->max_selected > 0)
                    <p>{!! sprintf(lang('igniter.cart::default.text_option_summary'), $menuOption->min_selected, $menuOption->max_selected) !!}</p>
                @endif
            </div>

            @if (count($optionValues = $menuOption->menu_option_values))
                <input
                    type="hidden"
                    wire:model.fill="menuOptions.{{ $index }}.menu_option_id"
                    value="{{ $menuOption->menu_option_id }}"
                />
                <div class="option-group">
                    @if(!$menuOption->option->isSelectDisplayType() && $limitOptionsValues && $optionValues->count() >= $limitOptionsValues)
                        @include('igniter-orange::includes.cartbox.item-options-'.$menuOption->display_type, [
                            'optionValues' => $optionValues->sortBy('priority')->slice(0, $limitOptionsValues),
                        ])

                        <div class="hidden-item-options" style="display: none;">
                            @include('igniter-orange::includes.cartbox.item-options-'.$menuOption->display_type, [
                                'optionValues' => $optionValues->sortBy('priority')->slice($limitOptionsValues-1),
                            ])
                        </div>
                        <button
                            type="button"
                            data-toggle="more-options"
                            class="btn btn-link"
                        >@lang('igniter.orange::default.button_show_more_options')</button>
                    @else
                        @include('igniter-orange::includes.cartbox.item-options-'.$menuOption->display_type)
                    @endif
                </div>
            @endif
        </div>
    </div>
@endforeach
