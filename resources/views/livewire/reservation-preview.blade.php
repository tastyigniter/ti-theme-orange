<div>
    <div class="card mb-1">
        <div class="card-body">
            <x-igniter-orange::local-header/>
        </div>
    </div>
    @if ($showCancelButton)
        <div class="card">
            <div class="card-body text-center">
                <button
                    class="btn btn-light text-danger"
                    wire:click="onCancel"
                    wire:loading.class="disabled"
                >@lang('igniter.reservation::default.button_cancel')</button>
                <x-igniter-orange::forms.error field="onCancel" class="text-danger text-center"/>
            </div>
        </div>
    @endif

    <div class="card">
        <div class="card-body p-0">
            <div class="d-flex">
                <div class="col-md-6 p-3 border">
                    <h6 class="small text-muted">@lang('admin::lang.column_id')</h6>
                    <span class="h4">{{ $reservation->reservation_id }}</span>
                </div>
                <div class="col-md-6 p-3 border">
                    <h6 class="small text-muted">@lang('igniter.reservation::default.column_status')</h6>
                    <span
                        class="h4"
                        style="color:{{$reservation->status_color}};"
                    >{{ $reservation->status_name }}</span>
                </div>
            </div>
            <div class="d-flex">
                <div class="col-md-6 p-3 border">
                    <h6 class="small text-muted">@lang('igniter.reservation::default.column_date')</h6>
                    <span class="h4">
                        {{ $reservation->reserve_date->setTimeFromTimeString($reservation->reserve_time)->isoFormat(lang('system::lang.moment.date_time_format_short')) }}
                    </span>
                </div>
                <div class="col-md-6 p-3 border">
                    <h6 class="small text-muted">@lang('igniter.reservation::default.column_table')</h6>
                    <span class="h4">{{ implode(', ', $reservation->tables->pluck('table_name')->all()) }}</span>
                </div>
            </div>
            <div class="d-flex">
                <div class="col-md-6 p-3 border">
                    <h6 class="small text-muted">@lang('igniter.reservation::default.column_guest')</h6>
                    <span class="h4">{{ $reservation->guest_num }}</span>
                </div>
                <div class="col-md-6 p-3 border">
                    <h6 class="small text-muted">@lang('igniter.reservation::default.column_location')</h6>
                    <span class="h4">
                        {{ $reservation->location->location_name }}<br/>
                        {{ format_address($reservation->location->getAddress()) }}
                    </span>
                </div>
            </div>
            <div class="d-flex">
                <div class="col-md-6 p-3 border">
                    <h6 class="small text-muted">@lang('admin::lang.label_name')</h6>
                    <span class="h4">{{ $reservation->first_name}} {{ $reservation->last_name }}</span>
                </div>
                <div class="col-md-6 p-3 border">
                    <h6 class="small text-muted">@lang('admin::lang.label_email')</h6>
                    <span class="h4">{{ $reservation->email }}</span>
                </div>
            </div>
            <div class="d-flex">
                <div class="col-md-6 p-3 border">
                    <h6 class="small text-muted">@lang('igniter.reservation::default.column_telephone')</h6>
                    <span class="h4">{{ $reservation->telephone }}</span>
                </div>
                <div class="col-md-6 p-3 border">
                    <h6 class="small text-muted">@lang('igniter.reservation::default.column_comment')</h6>
                    <span class="h4">{{ $reservation->comment }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
