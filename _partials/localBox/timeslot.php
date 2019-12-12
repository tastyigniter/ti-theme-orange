<?php
$orderDateTime = $location->orderDateTime();
$orderTimeIsAsap = $location->orderTimeIsAsap();
?>
<div
    class="dropdown"
>
    <button
        class="btn btn-light btn-timepicker btn-block dropdown-toggle text-truncate"
        type="button"
        id="orderTimePicker"
        data-toggle="dropdown"
        data-boundary="viewport"
        aria-haspopup="true"
        aria-expanded="false"
    >
        <i class="fa fa-clock-o"></i>&nbsp;&nbsp;
        <b><?=
            ($orderTimeIsAsap)
                ? lang('igniter.local::default.text_asap')
                : $orderDateTime->isoFormat($timePickerDateTimeFormat);
            ?></b>
    </button>

    <div class="dropdown-menu" aria-labelledby="orderTimePicker">
        <button
            type="button"
            class="dropdown-item py-2"
            data-timepicker-option="asap"
        ><i class="fa fa-clock-o"></i>&nbsp;&nbsp;<?= lang('igniter.local::default.text_asap'); ?></button>
        <button
            type="button"
            class="dropdown-item py-2"
            data-timepicker-option="later"
        ><i class="fa fa-calendar"></i>&nbsp;&nbsp;<?= lang('igniter.local::default.text_later'); ?></button>

        <form
            class="dropdown-content px-4 py-3 hide"
            role="form"
            data-request="<?= $timeSlotEventHandler; ?>"
        >
            <input type="hidden" data-timepicker-control="type" value="<?= $orderTimeIsAsap ? 'asap' : 'later' ?>">
            <div class="form-group">
                <select
                    class="form-control"
                    data-timepicker-control="date"
                    data-timepicker-label="<?= lang('igniter.local::default.label_date'); ?>"
                    data-timepicker-selected="<?= $orderDateTime ? $orderDateTime->format('Y-m-d') : '' ?>"
                ></select>
            </div>
            <div class="form-group">
                <select
                    class="form-control"
                    data-timepicker-control="time"
                    data-timepicker-label="<?= lang('igniter.local::default.label_time'); ?>"
                    data-timepicker-selected="<?= $orderDateTime ? $orderDateTime->format('H:i') : '' ?>"
                ></select>
            </div>
            <button
                type="button"
                class="btn btn-primary text-nowrap"
                data-timepicker-submit
                data-attach-loading
            >
                <?= sprintf(lang('igniter.local::default.label_choose_order_time'), $location->orderTypeIsDelivery()
                    ? lang('igniter.local::default.text_delivery')
                    : lang('igniter.local::default.text_collection'));
                ?>
            </button>
        </form>
    </div>
</div>
