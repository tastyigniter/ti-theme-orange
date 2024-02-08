<div>
    <div class="bg-white border-bottom border-1">
        <div class="container py-4">
            <div class="mb-3" wire:ignore>
                <a
                    wire:navigate
                    class="text-decoration-none"
                    href="{{page_url($goBackPage)}}"
                >
                    <i class="fa fa-arrow-left-long"></i>&nbsp;&nbsp;
                    @lang('igniter.orange::default.button_back')
                </a>
            </div>
            <div class="row align-items-end">
                <div class="col-md-8">
                    <x-igniter-orange::show-local-info/>
                </div>
                <div class="col-md-4 mt-4 mt-md-0">
                    <div class="local-control float-md-end">
                        <div class="d-inline-block border rounded py-2 px-3">
                            <x-igniter-orange::local-control />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="bg-white border-bottom border-1">
        <div class="container">
            <x-igniter-orange::list-categories/>
        </div>
    </div>
    <div class="container pt-3 pb-4">
        <div class="row">
            <div class="col-lg-8">
                <livewire:igniter-orange::list-menu-items />
            </div>

            <div class="col-lg-4 d-none d-lg-inline-block">
                <livewire:igniter-orange::cart-box/>
            </div>
        </div>
    </div>
    <div class="fixed-bottom d-block d-lg-none">
        <a
            wire:navigate
            class="btn btn-primary w-100 btn-lg radius-none cart-toggle text-nowrap"
            href="{{ page_url($cartPage) }}"
        >
            @lang('igniter.cart::default.text_heading'):
            <span class="fw-bold">{{ currency_format($cartTotal) }}</span>
        </a>
    </div>
    <livewire:igniter-orange::local-control-modal />
    <livewire:igniter-orange::address-picker-modal />
</div>
