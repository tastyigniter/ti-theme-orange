<div
    class="modal fade"
    id="localInfoModal"
    tabindex="-1"
    aria-labelledby="localInfoModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title ms-auto" id="localInfoModalLabel">@lang('main::lang.local.text_tab_info')</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h1 class="h5">{{ sprintf(lang('igniter.local::default.text_info_heading'), $locationInfo->name) }}</h1>

                <div class="mb-4">
                    @if (strlen($locationInfo->description ?? ''))
                        {{nl2br($locationInfo->description)}}
                    @endif
                </div>

                @foreach($locationInfo->orderTypes() as $code => $orderType)
                    <div class="border rounded p-3 mb-3">
                        @if ($orderType->isDisabled())
                            {!! $orderType->getDisabledDescription() !!}
                        @elseif ($orderType->getSchedule()->isOpen())
                            {!! $orderType->getOpenDescription()!!}
                        @elseif ($orderType->getSchedule()->isOpening())
                            {!! $orderType->getOpeningDescription(lang('system::lang.moment.day_time_format_short')) !!}
                        @else
                            {!! $orderType->getClosedDescription() !!}
                        @endif
                    </div>
                @endforeach
                @if ($locationInfo->hasDelivery)
                    <div class="border rounded p-3 mb-3">
                        @lang('igniter.local::default.text_last_order_time')&nbsp;
                        <b>{{ $locationInfo->lastOrderTime()->isoFormat(lang('system::lang.moment.day_time_format')) }}</b>
                    </div>
                @endif
                @if ($locationInfo->payments())
                    <div class="border rounded p-3 mb-3">
                        <i class="fas fa-credit-card fa-fw"></i>&nbsp;<b>@lang('igniter.local::default.text_payments')</b><br/>
                        {!! implode(', ', $locationInfo->payments()) !!}.
                    </div>
                @endif

                @includeWhen($locationInfo->hasDelivery, 'igniter-orange::includes.local.delivery-areas')

                @includeUnless(empty($locationInfo->scheduleItems()), 'igniter-orange::includes.local.hours')
            </div>
        </div>
    </div>
</div>
