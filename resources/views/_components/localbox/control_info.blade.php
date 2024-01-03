<strong>{{ $orderType->getLabel() }}</strong>
<span class="small center-block">
    @if ($orderType->getSchedule()->isOpen())
        @if ($orderType->getLeadTime())
            {!! sprintf(lang('igniter.local::default.text_in_min'), $orderType->getLeadTime()) !!}
        @endif
    @elseif ($orderType->getSchedule()->isOpening())
        {!! sprintf(lang('igniter.local::default.text_starts'), make_carbon($orderType->getSchedule()->getOpenTime())->isoFormat($openingTimeFormat)) !!}
    @elseif ($orderType->getSchedule()->isClosed())
        @lang('igniter.cart::default.text_is_closed')
    @endif
</span>
