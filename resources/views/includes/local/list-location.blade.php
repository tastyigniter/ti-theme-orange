<a
    class="card w-100 p-3 mb-2 text-decoration-none"
    href="{{ $locationData->url($menusPage) }}"
>
    <div class="boxes d-sm-flex g-0">
        <div class="col-12 col-sm-7">
            <div class="d-sm-flex">
                @if($locationData->hasThumb())
                    <div class="col-sm-3 p-0 me-sm-4 mb-3 mb-sm-0">
                        <img
                            class="img-fluid img-fluid"
                            src="{{ $locationData->getThumb() }}"
                            alt="{{$locationData->name}}"
                        />
                    </div>
                @endif
                <div class="no-spacing">
                    <div class="d-flex flex-row mb-2">
                        <h2 class="h5 mb-0 text-body">{{ $locationData->name }}</h2>
                        @if($showReviews)
                            <div class="rating rating-sm text-muted">
                                @for ($value = 1; $value<6; $value++)
                                    <span @class(['fa-star', 'fa' => $value <= $locationData->reviewsScore(), 'far' => $value >= $locationData->reviewsScore()])></span>
                                @endfor
                                <span class="small">({{ $locationData->reviewsCount() }})</span>
                            </div>
                        @endif
                    </div>
                    <div class="text-muted text-truncate">
                        {{ format_address($locationData->address) }}
                    </div>
                    @if($locationData->distance())
                        <div>
                            <span
                                class="text-muted small"
                            ><i class="fa fa-map-marker"></i>&nbsp;&nbsp;{{ number_format($locationData->distance(), 1) }} {{ $distanceUnit }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-5">
            <dl class="no-spacing">
                @if ($locationData->openingSchedule()->isOpen())
                    <dt>@lang('igniter.local::default.text_is_opened')</dt>
                @elseif ($locationData->openingSchedule()->isOpening())
                    <dt class="text-muted">{!! sprintf(lang('igniter.local::default.text_opening_time'), make_carbon($locationData->openingSchedule()->getOpenTime()())->isoFormat(lang('igniter::system.moment.day_time_format_short'))) !!}</dt>
                @else
                    <dt class="text-muted">@lang('igniter.local::default.text_closed')</dt>
                @endif
                @foreach($locationData->orderTypes() as $code => $orderType)
                    <dd class="text-muted">
                        @if($orderType->isDisabled())
                            {!! $orderType->getDisabledDescription() !!}
                        @elseif($orderType->getSchedule()->isOpen())
                            {!! $orderType->getOpenDescription() !!}
                        @elseif($orderType->getSchedule()->isOpening())
                            {!! $orderType->getOpeningDescription(lang('igniter::system.moment.day_time_format_short')) !!}
                        @else
                            {!! $orderType->getClosedDescription() !!}
                        @endif
                    </dd>
                @endforeach
            </dl>
        </div>
    </div>
</a>
