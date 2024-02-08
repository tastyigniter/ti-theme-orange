<div class="mb-4 py-3 border-top border-bottom border-2 fs-5">
    <i class="far fa-clock text-muted"></i>&nbsp;&nbsp;
    {{ $locationOrderType->getLabel() }}&nbsp;·
    @if ($order->order_time_is_asap)
        {!! sprintf(lang('igniter.local::default.text_in_min'), $locationOrderType->getLeadTime()) !!}
    @else
        @if($order->order_datetime->isToday())
            @lang('system::lang.date.today')&nbsp;{{$order->order_datetime->isoFormat(lang('system::lang.moment.time_format'))}}
        @elseif($order->order_datetime->isTomorrow())
            @lang('system::lang.date.tomorrow')&nbsp;{{$order->order_datetime->isoFormat(lang('system::lang.moment.time_format'))}}
        @else
            {{ $order->order_datetime->isoFormat(lang('system::lang.moment.day_time_format')) }}
        @endif
    @endif
    &nbsp;&nbsp;
    <a
        role="button"
        class="small text-primary"
        data-bs-toggle="modal"
        data-bs-target="#addressPickerModal"
    >@lang('igniter.local::default.search.text_change')</a>
</div>
