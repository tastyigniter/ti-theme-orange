<div class="panel-local d-md-flex">
    @if ($showThumb && $locationInfo->hasThumb())
        <img
            class="img-fluid rounded me-4"
            src="{{ $locationInfo->getThumb(['width' => $localThumbWidth, 'height' => $localThumbHeight]) }}"
            alt="{{ $locationInfo->name }}"
        />
    @endif
    <div>
        <h1 class="h3 mb-1">{{ $locationInfo->name }}</h1>
        <div style="--bs-breadcrumb-divider: '·';">
            <div class="breadcrumb mb-1">
                @if ($allowReviews)
                    <div class="breadcrumb-item">
                        <div class="rating rating-sm">
                            @for ($value = 1; $value<6; $value++)
                                <span @class(['fa-star', 'fa' => $value <= $locationInfo->reviewsScore(), 'far' => $value >= $locationInfo->reviewsScore()])></span>
                            @endfor
                            <a
                                wire:click="$dispatch('openModal', {component: 'igniter-orange::local-reviews-modal'})"
                                class="link-primary cursor-pointer"
                            ><span class="small">({{ $locationInfo->reviewsCount() }})</span></a>
                        </div>
                    </div>
                @endif
                <div class="breadcrumb-item fw-bold">
                    @if ($locationInfo->orderType()->getSchedule()->isOpen())
                        @lang('igniter.local::default.text_is_opened')
                    @elseif ($locationInfo->orderType()->getSchedule()->isOpening())
                        {!! sprintf(lang('igniter.local::default.text_opening_time'), make_carbon($locationInfo->orderType()->getSchedule()->getOpenTime())->isoFormat(lang('igniter::system.moment.day_time_format_short'))) !!}
                    @else
                        @lang('igniter.local::default.text_closed')
                    @endif
                </div>
                @if ($locationInfo->orderType()->getSchedule()->isOpen())
                    @if ($locationInfo->orderType()->getLeadTime())
                        <div class="breadcrumb-item">
                            {!! sprintf(lang('igniter.local::default.text_in_min'), $locationInfo->orderType()->getLeadTime()) !!}
                        </div>
                    @endif
                @elseif ($locationInfo->orderType()->getSchedule()->isOpening())
                    <div class="breadcrumb-item">
                        {!! sprintf(lang('igniter.local::default.text_starts'), make_carbon($locationInfo->orderType()->getSchedule()->getOpenTime())->isoFormat(lang('igniter::system.moment.day_time_format_short'))) !!}
                    </div>
                @endif
                <div class="breadcrumb-item">
                    <a
                        class="link-dark fw-bold cursor-pointer"
                        data-bs-toggle="modal"
                        data-bs-target="#localInfoModal"
                    >More info</a>
                </div>
            </div>
        </div>
        <div class="text-muted">
            {!! format_address($locationInfo->address, FALSE) !!}
        </div>
    </div>
    @include('igniter-orange::includes.local.info-modal')
</div>
