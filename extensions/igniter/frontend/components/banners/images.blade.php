@if ($banner->type != 'carousel')
    @foreach ($banner->value as $image)
        <div
            class="thumbnail"
            data-width="{{ $image['width'] }}"
            data-height="{{ $image['height'] }}"
        >
            <a href="{{ $banner->clickUrl }}">
                <img
                    alt="{{ $banner->altText }}"
                    src="{{ $image['url'] }}"
                    class="thumb img-fluid"
                />
            </a>
        </div>
    @endforeach
@else
    <div class="thumbnail">
        <div id="{{ $banner->id }}" class="carousel slide" data-bs-ride="carousel">
            <ol class="carousel-indicators">
                @for ($i = 0; $i < count($banner->value); $i++)
                    <li
                        data-bs-target="#{{ $banner->id }}"
                        data-bs-slide-to="{{ $i }}"
                        class="{{ $i === 0 ? 'active' : '' }}"
                    ></li>
                @endfor
            </ol>

            <div class="carousel-inner">
                @foreach ($banner->value as $image)
                    <div
                        class="item {{ $loop->index === 0 ? 'active' : '' }}"
                        data-width="{{ $image['width'] }}"
                        data-height="{{ $image['height'] }}"
                    >
                        <a href="{{ $banner->clickUrl }}">
                            <img
                                class="img-fluid"
                                alt="{{ $banner->altText }}"
                                src="{{ $image['url'] }}"
                            />
                        </a>
                    </div>
                @endforeach
            </div>

            <a
                class="left carousel-control"
                href="#{{ $banner->id }}"
                data-bs-slide="prev"><span class="fa fa-chevron-left"></span></a>
            <a
                class="right carousel-control"
                href="#{{ $banner->id }}"
                data-bs-slide="next"><span class="fa fa-chevron-right"></span></a>
        </div>
    </div>
@endif
