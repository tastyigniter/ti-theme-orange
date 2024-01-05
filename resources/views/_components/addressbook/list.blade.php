@if (count($customerAddresses))
    <div class="list-group list-group-flush">
        @foreach ($customerAddresses as $address)
            <div
                    class="list-group-item {{ ($customer->address_id == $address->address_id) ? 'list-group-item-info' : '' }}"
            >
                <address class="text-left">{{ format_address($address) }}</address>
                <span class="">
                    <a
                            class="btn btn-outline-default"
                            href="{{ page_url('account/address', ['addressId' => $address->address_id]) }}"
                    >@lang('igniter.user::default.account.text_edit')</a>
                    <button
                            type="button"
                            class="btn text-danger pull-right"
                            data-request="accountAddressBook::onDelete"
                            data-request-data="addressId: '{{ $address->address_id }}'"
                    >@lang('igniter.user::default.account.text_delete')</button>
                    @if ($customer->address_id != $address->address_id)
                        <a
                                class="btn btn-outline-default"
                                href="{{ site_url('account/address', ['addressId' => $address->address_id]) }}?setDefault=1"
                        >@lang('igniter.user::default.text_set_default')</a>
                    @endif
                </span>
            </div>
        @endforeach
    </div>

    <div class="pagination-bar text-right">
        <div class="links">{!! $customerAddresses->links() !!}</div>
    </div>
@else
    <p>@lang('igniter.user::default.account.text_no_address')</p>
@endif

<div class="buttons">
    <button
            class="btn btn-primary btn-lg"
            data-request="{{ $addAddressEventHandler }}"
    >@lang('igniter.user::default.account.button_add')</button>
</div>
