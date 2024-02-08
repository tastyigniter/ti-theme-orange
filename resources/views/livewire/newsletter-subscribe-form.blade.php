<div>
    @unless($message)
        <x-igniter-orange::forms.form
            id="subscribeForm"
            class="subscribe-form"
            wire:sumbit="onSubscribe"
        >
            <div class="input-group subscribe-group">
                <input
                    wire:model="email"
                    name="email"
                    type="text"
                    class="form-control rounded-pill"
                >
                <button
                    type="submit"
                    id="subscribeButton"
                    class="btn btn btn-light rounded-pill ms-2"
                ><i class="fa fa-paper-plane"></i></button>
            </div>
        </x-igniter-orange::forms.form>
    @else
        <div class="alert alert-success">
            {{ $message }}
        </div>
    @endunless
</div>
