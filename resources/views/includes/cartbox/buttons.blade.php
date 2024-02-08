@php $locationIsClosed = ($this->locationIsClosed() || $this->hasMinimumOrder()); @endphp
<button
    @class(['checkout-btn btn btn-primary w-100 btn-lg', 'disabled' => $locationIsClosed])
    wire:loading.class="disabled"
    wire:click="onProceedToCheckout({{ $this->getLocationId() }})"
>{{ $this->buttonLabel($checkout ?? null) }}</button>
