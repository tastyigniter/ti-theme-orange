@if (count($locationInfo->scheduleItems))
    <div class="px-3">
        <ul class="nav nav-tabs justify-content-center">
            @foreach ($locationInfo->scheduleTypes as $code => $definition)
                <li class="nav-item">
                    <a
                            role="button"
                            @class(['nav-link', 'active' => $code == $locationInfo->orderType->getCode()])
                            data-bs-toggle="tab"
                            data-bs-target="#{{$code}}"
                    >@lang(array_get($definition, 'name'))</a>
                </li>
            @endforeach
        </ul>
        <div class="tab-content border-top">
            @foreach ($locationInfo->scheduleItems as $code => $schedules)
                <div
                        @class(['tab-pane', 'active' => $code == $locationInfo->orderType->getCode()])
                        id="{{$code}}"
                        role="tabpanel"
                        aria-labelledby="{{$code}}-tab"
                >
                    <div class="list-group list-group-flush">
                        @foreach ($schedules as $day => $hours)
                            <div class="list-group-item px-0">
                                <div class="d-flex justify-content-between">
                                    <div class="text-muted">{{ $day }}</div>
                                    <div class="text-right text-nowrap text-truncate">
                                        @forelse($hours as $hour)
                                            @php($formatted = sprintf('%s-%s', $hour['open'], $hour['close']))
                                            <span title="{{ $formatted }}">{{ $formatted }}</span>
                                        @empty
                                            <span>@lang('igniter.local::default.text_closed')</span>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif
