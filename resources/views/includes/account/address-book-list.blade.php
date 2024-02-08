<div class="list-group list-group-flush">
    @foreach ($addresses as $address)
        <div
            class="list-group-item {{ ($defaultAddressId == $address->address_id) ? 'list-group-item-info' : '' }}"
        >
            <address class="text-left">{{ format_address($address) }}</address>
            <div class="">
                <a
                    class="btn btn-link"
                    wire:click="$set('addressId', {{$address->address_id}})"
                    wire:loading.class="disabled"
                >@lang('igniter.user::default.account.text_edit')</a>
                <button
                    type="button"
                    class="btn text-danger pull-right"
                    wire:click="onDelete({{ $address->address_id }})"
                    wire:loading.class="disabled"
                >@lang('igniter.user::default.account.text_delete')</button>
                @if ($defaultAddressId != $address->address_id)
                    <a
                        class="btn btn-link"
                        wire:click="onSetDefault({{ $address->address_id }})"
                        wire:loading.class="disabled"
                    >@lang('igniter.user::default.text_set_default')</a>
                @endif
            </div>
        </div>
    @endforeach
</div>

<div class="d-flex justify-content-between">
    <div class="links">{{$addresses->links()}}</div>

    <div class="buttons">
        <button
            class="btn btn-primary"
            wire:click="$set('addressId', '')"
            wire:loading.class="disabled"
        >@lang('igniter.user::default.account.button_add')</button>
    </div>
</div>
