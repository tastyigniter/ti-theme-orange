<div class="table-responsive">
    <table class="table table-borderless">
        <tr>
            <td><b>@lang('admin::lang.column_id'):</b></td>
            <td>{{ $reservation->reservation_id }}</td>
        </tr>
        <tr>
            <td><b>@lang('igniter.reservation::default.column_status'):</b></td>
            <td>
                <span style="color:{{$reservation->status_color}};">{{ $reservation->status_name }}</span>
            </td>
        </tr>
        <tr>
            <td><b>@lang('igniter.reservation::default.column_date'):</b></td>
            <td>
                {{ $reservation->reserve_date->setTimeFromTimeString($reservation->reserve_time)->isoFormat(lang('system::lang.moment.date_time_format_short')) }}
            </td>
        </tr>
        <tr>
            <td><b>@lang('igniter.reservation::default.column_table'):</b></td>
            <td>{{ implode(', ', $reservation->tables->pluck('table_name')->all()) }}</td>
        </tr>
        <tr>
            <td><b>@lang('igniter.reservation::default.column_guest'):</b></td>
            <td>{{ $reservation->guest_num }}</td>
        </tr>
        <tr>
            <td><b>@lang('igniter.reservation::default.column_location'):</b></td>
            <td>
                {{ $reservation->location->location_name }}<br />
                {{ format_address($reservation->location->getAddress()) }}
            </td>
        </tr>
        <tr>
            <td><b>@lang('admin::lang.label_name'):</b></td>
            <td>{{ $reservation->first_name}}{{ $reservation->last_name }}</td>
        </tr>
        <tr>
            <td><b>@lang('admin::lang.label_email'):</b></td>
            <td>{{ $reservation->email }}</td>
        </tr>
        <tr>
            <td><b>@lang('igniter.reservation::default.column_telephone'):</b></td>
            <td>{{ $reservation->telephone }}</td>
        </tr>
        <tr>
            <td><b>@lang('igniter.reservation::default.column_comment'):</b></td>
            <td>{{ $reservation->comment }}</td>
        </tr>
    </table>
</div>
@if ($__SELF__->showCancelButton())
    <hr>
    <div class="mt-3 text-center">
        <button
            class="btn btn-light text-danger"
            data-request="{{ $__SELF__.'::onCancel' }}"
            data-request-data="reservationId: {{ $reservation->reservation_id }}"
            data-attach-loading
        >@lang('igniter.reservation::default.button_cancel')</button>
    </div>
@endif
