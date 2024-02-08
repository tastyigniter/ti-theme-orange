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
<div>
    @foreach ($this->orderTypes as $key => $name)
        <div class="bg-white border rounded-pill p-2 ps-3 mb-2">
            <div class="form-check">
                <input
                    wire:model.live="orderType"
                    wire:loading.attr="disabled"
                    name="orderType"
                    type="radio"
                    id="customRadio{{$key}}"
                    class="form-check-input"
                    value="{{$key}}"
                />
                <label
                    class="form-check-label w-100"
                    for="customRadio{{$key}}"
                >@lang($name)</label>
            </div>
        </div>
    @endforeach
</div>
