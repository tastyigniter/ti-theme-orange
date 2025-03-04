<div>
    <div class="card mb-1">
        <div class="card-body">
            {!! $customer
                ? sprintf(lang('igniter.orange::default.text_logged_out'), e($customer->first_name), url('logout'))
                : sprintf(lang('igniter.orange::default.text_logged_in'), page_url('account.login'))
            !!}
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div data-control="booking">
                @if ($pickerStep == $this::STEP_BOOKING)
                    @include('igniter-orange::includes.booking.info')

                    @include('igniter-orange::includes.booking.booking-form')

                @elseif ($pickerStep == $this::STEP_TIMESLOT)
                    <h1 class="h3">@lang('igniter.reservation::default.text_time_heading')</h1>

                    @include('igniter-orange::includes.booking.timeslot')
                @else
                    <h1 class="h3">@lang('igniter.reservation::default.text_booking_title')</h1>

                    @includeWhen($useCalendarView, 'igniter-orange::includes.booking.picker-form')
                    @includeWhen(!$useCalendarView, 'igniter-orange::includes.booking.picker-inline-form')
                @endif
            </div>
        </div>
    </div>
</div>
