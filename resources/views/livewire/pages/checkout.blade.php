<div>
    <div class="row pt-4">
        <h1>@lang('igniter.orange::default.text_title_checkout') {{ $locationCurrent->getName() }}</h1>

        <div class="my-3">
            {!! $customer
                ? sprintf(lang('igniter.orange::default.text_logged_out'), e($customer->first_name), 'onLogout')
                : sprintf(lang('igniter.orange::default.text_logged_in'), page_url('account/login'))
            !!}
        </div>
    </div>
    <div class="row py-4">
        <div class="col col-lg-8">
            <div data-control="checkout" data-partial="checkoutForm">
                @includeWhen($isTwoStepCheckout, 'igniter-orange::includes.checkout.two-step-form')
                @includeUnless($isTwoStepCheckout, 'igniter-orange::includes.checkout.one-step-form')
            </div>
        </div>

        <div class="col-lg-4">
            <livewire:igniter-orange::cart-box :showCheckoutButton="false" />
        </div>
    </div>
    <livewire:igniter-orange::local-control-modal />
    <livewire:igniter-orange::address-picker-modal />
</div>
