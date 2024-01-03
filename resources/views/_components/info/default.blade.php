<div class="panel">
    @if (strlen($locationInfo->description))
        <div class="panel-body">
            <h1
                    class="h4 wrap-bottom border-bottom"
            >{{ sprintf(lang('igniter.local::default.text_info_heading'), $locationInfo->name) }}</h1>
            <p class="m-0">{!! nl2br($locationInfo->description) !!}</p>
        </div>
    @endif

    <div class="list-group list-group-flush">
        @foreach($locationInfo->orderTypes as $code => $orderType)
            <div class="list-group-item">
                @if ($orderType->isDisabled())
                    {!! $orderType->getDisabledDescription() !!}
                @elseif ($orderType->getSchedule()->isOpen())
                    {!! $orderType->getOpenDescription()!!}
                @elseif ($orderType->getSchedule()->isOpening())
                    {!! $orderType->getOpeningDescription($openingTimeFormat) !!}
                @else
                    {!! $orderType->getClosedDescription() !!}
                @endif
            </div>
        @endforeach
        @if ($locationInfo->hasDelivery)
            <div class="list-group-item">
                @lang('igniter.local::default.text_last_order_time')&nbsp;
                <b>{{ $locationInfo->lastOrderTime->isoFormat($lastOrderTimeFormat) }}</b>
            </div>
        @endif
        @if ($locationInfo->payments)
            <div class="list-group-item">
                <i class="fas fa-credit-card fa-fw"></i>&nbsp;<b>@lang('igniter.local::default.text_payments')</b><br/>
                {!! implode(', ', $locationInfo->payments) !!}.
            </div>
        @endif
    </div>

    @themePartial('@areas')

    <h4 class="panel-title p-3"><b>@lang('igniter.local::default.text_hours')</b></h4>

    @themePartial('@hours')
</div>

