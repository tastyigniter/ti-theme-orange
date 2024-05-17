<select
    wire:model="time"
    name="time"
    id="time"
    @class(['form-select', 'is-invalid' => has_form_error('time')])
>
    <option value="">@lang('igniter.orange::default.text_select_time')</option>
    @foreach ($this->timeslots as $dateTime)
        <option value="{{ $dateTime->format('H:i') }}">{{ $dateTime->isoFormat(lang('system::lang.moment.time_format')) }}</option>
    @endforeach
</select>
