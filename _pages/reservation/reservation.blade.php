---
title: main::lang.reservation.title
layout: default
permalink: ':location/reservation'

'[account]':

'[booking]':
    timePickerInterval: 180
    timeSlotsInterval: 120
---
<div class="container">
    <div class="row py-4">
        <div class="col col-sm-10 center-block">
            <div class="card mb-1">
                <div class="card-body">
                    @themePartial('account/welcome')
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    @componentPartial('booking')
                </div>
            </div>
        </div>
    </div>
</div>
