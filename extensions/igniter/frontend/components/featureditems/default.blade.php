@if (count($featuredMenuItems))
    <div id="featured-menu-box" class="module-box py-5">
        <div class="container text-center">
            <h2 class="mb-3">{{ $featuredTitle }}</h2>

            <div class="row">
                @foreach ($featuredMenuItems as $featuredItem)
                    <div class="col-sm-{{ round(12 / $featuredPerRow) }} mb-3 mb-sm-0">
                        <a
                            class="text-decoration-none text-reset"
                            href="{{page_url('local/menus', ['location' => optional($featuredItem->locations->first())->permalink_slug])}}?menuId={{ $featuredItem->getBuyableIdentifier() }}"
                        >
                            <div class="card h-100">
                                @if ($featuredItem->hasMedia())
                                    <img
                                        class="card-img-top"
                                        src="{{ $featuredItem->getThumb([
                                        'width' => $featuredWidth,
                                        'height' => $featuredHeight,
                                    ]) }}" alt="{{ $featuredItem->getBuyableName() }}"
                                    />
                                @endif
                                <div class="card-body">
                                    <h4 class="card-title">
                                        {{ $featuredItem->getBuyableName() }}
                                        <small>{{ currency_format($featuredItem->getBuyablePrice()) }}</small>
                                    </h4>
                                    <h6>{{$featuredItem->locations->implode('location_name', ',')}}</h6>
                                    <p class="card-text">{{ $featuredItem['menu_description'] }}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif
