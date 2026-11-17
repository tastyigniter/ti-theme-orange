<div>
    @if (count($featuredLocations))
        <div id="featured-locations-box" class="module-box py-5">
            <div class="container">
                <h2 class="mb-3 text-center">@lang($title)</h2>

                <div class="row g-3">
                    @foreach ($featuredLocations as $locationData)
                        <div class="col-sm-{{ round(12 / max(1, $itemsPerRow)) }}">
                            <a class="text-decoration-none text-reset" href="{{ $locationData->url($menusPage) }}">
                                <div class="card rounded-5 h-100 shadow-sm">
                                    @if ($showThumb && $locationData->hasThumb())
                                        <img
                                            class="card-img-top rounded-5"
                                            src="{{ $locationData->getThumb(['width' => 400, 'height' => 250]) }}"
                                            alt="{{ $locationData->name }}"
                                        />
                                    @endif
                                    <div class="card-body p-4">
                                        <span class="badge text-bg-warning mb-2">@lang('igniter.orange::default.text_featured')</span>
                                        <h5 class="card-title">{{ $locationData->name }}</h5>
                                        <p class="card-text text-muted small mb-3">{{ format_address($locationData->address, false) }}</p>
                                        <span class="btn btn-primary btn-sm">@lang('igniter.orange::default.button_order_now')</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>
