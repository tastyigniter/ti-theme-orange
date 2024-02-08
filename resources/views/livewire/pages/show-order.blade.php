<div>
    <div class="row py-5">
        @if ($customer)
            <div class="col-sm-3">
                <x-igniter-orange::nav code="account-menu" />
            </div>
        @endif

        <div class="col-sm-9{{ $customer ? '' : ' m-auto' }}">
            @if (!$order)
                <div class="card mb-1">
                    <div class="card-body text-center" id="ti-order-status">
                        No order found
                    </div>
                </div>
            @else
                <div class="card mb-1">
                    <div class="card-body text-center" id="ti-order-status">
                        @include('igniter-orange::includes.order.status')
                    </div>
                </div>

                @auth('igniter-customer')
                    <div class="card mb-1">
                        <div class="card-body text-center">
                            <a
                                href="{{ $loginUrl }}"
                            >@lang('igniter.cart::default.orders.text_login_to_view_more')</a>
                        </div>
                    </div>
                @else
                    @if ($showReviews && !empty($reviewable))
                        <div class="card mb-1">
                            <div class="card-body">
                                <livewire:igniter-orange::leave-review />
                            </div>
                        </div>
                    @endif

                    <div class="row g-0">
                        <div class="col-sm-7 pe-sm-1">
                            <div class="card mb-1">
                                <div class="card-body">
                                    @include('igniter-orange::includes.order.restaurant', ['location' => $order->location])
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    @include('igniter-orange::includes.order.items')
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-5">
                            @include('igniter-orange::includes.order.details')
                        </div>
                    </div>
                @endauth
            @endif
        </div>
    </div>
</div>
