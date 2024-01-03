@php
    $orderDateTime = $location->orderDateTime();
    $orderTimeIsAsap = $location->orderTimeIsAsap();
@endphp
@if (!$location->checkOrderTime() || $location->checkNoOrderTypeAvailable())
    <button
            class="btn btn-light btn-timepicker btn-block text-truncate active"
            id="orderTimePicker"
    >
        <i class="far fa-clock"></i>&nbsp;&nbsp;
        <b>@lang('igniter.cart::default.text_is_closed')</b>
    </button>
@elseif ($orderTimeIsAsap && !$location->hasLaterSchedule())
    <button
            class="btn btn-light btn-timepicker btn-block text-truncate active"
            id="orderTimePicker"
    >
        <i class="far fa-clock"></i>&nbsp;&nbsp;
        <b>@lang('igniter.local::default.text_asap')</b>
    </button>
@else
    <div
            class="dropdown"
            data-control="timepicker"
            data-time-slot='@json($locationTimeslot)'
    >
        <button
                class="btn btn-light btn-timepicker btn-block dropdown-toggle text-truncate"
                type="button"
                id="orderTimePicker"
                data-bs-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
        >
            <i class="far fa-clock"></i>&nbsp;&nbsp;
            <b>
                @if ($orderTimeIsAsap)
                    @lang('igniter.local::default.text_asap')
                @else
                    {{ $orderDateTime->isoFormat($timePickerDateTimeFormat) }}
                @endif
            </b>
        </button>

        <div class="dropdown-menu w-100" aria-labelledby="orderTimePicker">
            @if ($location->hasAsapSchedule())
                <button
                        type="button"
                        class="dropdown-item py-2"
                        data-timepicker-option="asap"
                ><i class="fa fa-clock-o"></i>&nbsp;&nbsp;@lang('igniter.local::default.text_asap')</button>
            @endif
            @if ($location->hasLaterSchedule())
                <button
                        type="button"
                        class="dropdown-item py-2"
                        data-timepicker-option="later"
                ><i class="fa fa-calendar"></i>&nbsp;&nbsp;@lang('igniter.local::default.text_later')</button>

                <form
                        class="dropdown-content px-4 py-3 hide"
                        role="form"
                        data-request="{{ $timeSlotEventHandler }}"
                >
                    <input
                            type="hidden"
                            data-timepicker-control="type"
                            value="{{ $orderTimeIsAsap ? 'asap' : 'later' }}"
                            autocomplete="off"
                    />
                    <div class="row g-0">
                        <div class="col pe-1">
                            <div class="form-group">
                                <select
                                        class="form-select"
                                        data-timepicker-control="date"
                                        data-timepicker-label="@lang('igniter.local::default.label_date')"
                                        data-timepicker-selected="{{ $orderDateTime ? $orderDateTime->format('Y-m-d') : '' }}"
                                ></select>
                            </div>
                        </div>
                        <div class="col pl-1">
                            <div class="form-group">
                                <select
                                        class="form-select"
                                        data-timepicker-control="time"
                                        data-timepicker-label="@lang('igniter.local::default.label_time')"
                                        data-timepicker-selected="{{ $orderDateTime ? $orderDateTime->format('H:i') : '' }}"
                                ></select>
                            </div>
                        </div>
                    </div>
                    <button
                            type="button"
                            class="btn btn-block btn-outline-primary text-nowrap"
                            data-timepicker-submit
                            data-attach-loading
                    >
                        {{ sprintf(lang('igniter.local::default.label_choose_order_time'), $location->getOrderType()->getLabel()) }}
                    </button>
                </form>
            @endif
        </div>
    </div>
@endif
