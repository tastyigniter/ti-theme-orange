---
title: 'main::lang.reservation.title'
layout: default
permalink: /reservation
'[account]': null
'[booking]': null
mode: 1
maxGuestSize: !!float 20
datePickerNoOfDays: !!float 30
timePickerInterval: !!float 30
timeSlotsInterval: !!float 15
bookingDateFormat: 'MMM DD, YYYY'
bookingTimeFormat: 'h:mm a'
bookingDateTimeFormat: 'dddd, MMMM D, YYYY \a\t h:mm a'
showLocationThumb: 1
locationThumbWidth: !!float 95
locationThumbHeight: !!float 80
bookingPage: reservation/reservation
successPage: reservation/success
description: ''
menusPage: local/menus
hideEmptyCategory: 1
---
<div class="container">
    <div class="row py-4">
        <div class="col col-sm-10 center-block">
            <div class="card">
                <div class="card-body">
                    <?= component('booking'); ?>
                </div>
            </div>
        </div>
    </div>
</div>