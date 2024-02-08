<div>
    <div class="row py-4">
        <div class="col col-lg-10 m-auto">
            <div class="card mb-1">
                <div class="card-body">
                    <x-igniter-orange::show-local-info/>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <p>
                        {!! sprintf(lang('igniter.reservation::default.text_greetings'),
                            e($reservation->first_name).' '.e($reservation->last_name)) !!}
                    </p>

                    <p>
                        {!! sprintf(lang('igniter.reservation::default.text_success_message'),
                            e($reservation->location->location_name),
                            e($reservation->guest_num),
                            e($reservation->reservation_datetime->isoFormat(lang('system::lang.moment.date_time_format_long')))) !!}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
