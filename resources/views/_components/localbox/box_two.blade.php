@php
    $openingTime = make_carbon($locationCurrentSchedule->getOpenTime());
@endphp
<dl class="no-spacing">
    @if ($locationCurrentSchedule->isOpen())
        <dt>@lang('igniter.local::default.text_is_opened')</dt>
    @elseif ($locationCurrentSchedule->isOpening())
        <dt class="text-muted">{!! sprintf(lang('igniter.local::default.text_opening_time'), $openingTime->isoFormat($openingTimeFormat)) !!}</dt>
    @else
        <dt class="text-muted">@lang('igniter.local::default.text_closed')</dt>
    @endif

    <dd>
        @if ($openingTime->isToday() && $locationCurrentSchedule->getPeriod($openingTime)->opensAllDay())
            <span class="fa fa-clock"></span>&nbsp;&nbsp;
            <span>@lang('igniter.local::default.text_24_7_hour')</span>
        @elseif ($openingHours = $__SELF__->getOpeningHours($localBoxTimeFormat))
            <span class="fa fa-clock-o"></span>&nbsp;
            {!! implode(', ', $openingHours) !!}
        @endif
    </dd>

    <dd class="text-muted">
        @if (!$locationCurrent->hasDelivery() && $locationCurrent->hasCollection())
            @lang('igniter.local::default.text_collection_only')
        @elseif ($locationCurrent->hasDelivery() && !$locationCurrent->hasCollection())
            @lang('igniter.local::default.text_delivery_only')
        @elseif ($locationCurrent->hasDelivery() && $locationCurrent->hasCollection())
            @lang('igniter.local::default.text_both_types')
        @else
            @lang('igniter.local::default.text_no_types')
        @endif
    </dd>
    <dd class="text-muted">
        {!! implode(', ', $__SELF__->getAreaConditionLabels()) !!}
    </dd>
</dl>
