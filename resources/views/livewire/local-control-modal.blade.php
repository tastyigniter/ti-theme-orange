<div x-data='OrangeLocalControl(@json($timeslotTimes))'>
    <div
        class="modal fade"
        id="localControlModal"
        tabindex="-1"
        aria-labelledby="localControlModalLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-dialog-centered">
            <x-igniter-orange::forms.form class="w-100" wire:submit="onConfirm">
                <div class="modal-content">
                    <div class="modal-header px-4 border-bottom-0">
                        <h3 class="modal-title ms-auto" id="localControlModalLabel"></h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4 py-2">
                        <div class="pb-3">
                            @foreach($orderTypes as $orderType)
                                @continue($orderType->isDisabled())
                                <div @class(['form-check py-2', 'border-bottom' => !$loop->last])>
                                    <input
                                        wire:model="orderType"
                                        type="radio"
                                        name="orderType"
                                        id="orderType{{ $orderType->getCode() }}"
                                        class="form-check-input"
                                        value="{{ $orderType->getCode() }}"
                                        @checked($orderType->isActive())
                                    />
                                    <label
                                        class="form-check-label text-wrap ms-2 d-block"
                                        for="orderType{{ $orderType->getCode() }}"
                                    >{{ $orderType->getLabel() }}</label>
                                </div>
                            @endforeach
                        </div>
                        <div id="local-timeslot" class="pb-3">
                            <h6 class="mt-3">@lang('igniter.orange::default.text_pick_time')</h6>
                            @include('igniter-orange::includes.local.timeslot')
                        </div>
                        <div x-cloak x-show="showAddressPicker" class="pb-3">
                            <h6 class="my-3">
                                <i class="fa fa-map-pin"></i>&nbsp;&nbsp;
                                @lang('igniter.orange::default.text_delivering_to')
                                <a
                                    role="button"
                                    class="small text-primary"
                                    data-bs-toggle="modal"
                                    data-bs-target="#addressPickerModal"
                                >@lang('igniter.local::default.search.text_change')</a>
                            </h6>
                            <div class="p-2 border rounded bg-white w-100">
                                <div class="pe-2 text-truncate">{{ $deliveryAddress }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button
                            type="submit"
                            data-bs-dismiss="modal"
                            class="btn btn-primary btn-lg text-nowrap text-white w-100"
                            wire:loading.class="disabled"
                        >@lang('igniter.orange::default.button_confirm')</button>
                    </div>
                </div>
            </x-igniter-orange::forms.form>
        </div>
    </div>
</div>
