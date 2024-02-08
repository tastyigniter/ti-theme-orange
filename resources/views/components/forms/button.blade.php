<button
    class="btn btn-primary"
    wire:click="$set('addressId', '')"
    wire:loading.class="disabled"
>
    {{ $slot }}
</button>
