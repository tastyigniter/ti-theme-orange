<div
    class="modal fade"
    id="addressPickerModal"
    tabindex="-1"
    aria-labelledby="addressPickerModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
        <x-igniter-orange::forms.form class="modal-dialog-scrollable w-100" role="form" wire.submit="onConfirm">
            <div class="modal-content">
                <div class="modal-header px-4 border-bottom-0">
                    <h3 class="modal-title" id="addressPickerModalLabel">@lang('igniter.orange::default.text_choose_address')</h3>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-toggle="modal"
                        data-bs-target="#localControlModal"
                        aria-label="Close"
                    ></button>
                </div>
                <div class="modal-body p-4 pt-0">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item py-3 px-0 border-bottom-0">
                            <input
                                type="text"
                                id="search-query"
                                class="form-control form-control-lg bg-light"
                                name="search_query"
                                placeholder="@lang('igniter.local::default.label_search_query')"
                            />
                        </div>
                        @foreach ($this->savedAddresses as $address)
                            <div
                                class="list-group-item px-0 py-3"
                                data-address-picker-control="select"
                            >
                                <div class="form-check">
                                    <input
                                        type="radio"
                                        name="addressId"
                                        id="savedAddress{{ $address->address_id }}"
                                        class="form-check-input"
                                        value="{{ $address->address_id }}"
                                        @checked($selectedId === $address->address_id)
                                    />
                                    <label
                                        class="form-check-label text-wrap ms-2"
                                        for="savedAddress{{ $address->address_id }}"
                                    >{{ $address->formatted_address }}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer border-top-0">
                    <button
                        type="submit"
                        class="btn btn-primary btn-lg text-nowrap text-white w-100"
                        data-attach-loading
                    >@lang('igniter.orange::default.button_confirm')</button>
                </div>
            </div>
        </x-igniter-orange::forms.form>
    </div>
</div>
