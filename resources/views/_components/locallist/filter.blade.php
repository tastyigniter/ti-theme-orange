@if ($searchQueryPosition->isValid())
    <div class="card mb-3">
        <div class="card-body">
            <div class="d-flex">
                <h5 class="mb-0 d-inline-block flex-grow-1">
                    <i class="fa fa-map-marker"></i>&nbsp;&nbsp;
                    {{ $searchQueryPosition->getLocality() }}
                </h5>
                <a
                        class="text-primary"
                        href="{{ page_url('home') }}"
                >@lang('igniter.local::default.search.text_change')</a>
            </div>
        </div>
    </div>
@endif
<div class="card">
    <div class="list-group list-group-flush">
        @foreach ($listOrderTypes as $key => $name)
            <div class="list-group-item">
                <div class="form-check">
                    <input
                            type="radio"
                            id="customRadio{{$key}}"
                            name="{{ $orderTypeParam }}"
                            class="form-check-input"
                            value="{{$key}}"
                            data-page-url="{{ $filterPageUrl }}"
                            {!! $key == $activeOrderType ? 'checked=checked' : '' !!}
                    />
                    <label
                            class="form-check-label w-100"
                            for="customRadio{{$key}}"
                    >@lang($name)</label>
                </div>
            </div>
        @endforeach
    </div>
</div>
