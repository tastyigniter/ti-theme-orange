<div>
    <div class="bg-white border-bottom border-1">
        <div class="container py-4">
            <div class="mb-3" wire:ignore>
                <a
                    class="text-decoration-none"
                    href="{{page_url('local/menus')}}"
                >
                    <i class="fa fa-arrow-left-long"></i>&nbsp;&nbsp;
                    @lang('igniter.orange::default.button_back')
                </a>
            </div>
            <div class="row align-items-end">
                <div class="col-md-8">
                    <x-igniter-orange::local-header />
                </div>
            </div>
        </div>
    </div>
    <div class="container pt-3 pb-5">
        @include('igniter-orange::includes.local.reviews-list')
    </div>
</div>