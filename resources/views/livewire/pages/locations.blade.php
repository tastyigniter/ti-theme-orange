<x-igniter-orange::forms.form id="location-form">
    <div class="row py-4">
        <div class="locations-filter col-sm-3">
            @include('igniter-orange::includes.local.list-filter')
        </div>
        <div class="location-list col-sm-9">
            <div class="mb-4">
                @include('igniter-orange::includes.local.list-search')
            </div>

            <div class="d-flex flex-row mb-4">
                @foreach ($this->sorters as $key => $sorting)
                    <input
                        wire:model.live="sortBy"
                        wire:loading.attr="disabled"
                        type="radio"
                        class="btn-check"
                        name="sortBy"
                        id="sort-{{$key}}"
                        value="{{$key}}"
                        autocomplete="off"
                    />
                    <label
                        x-bind:class="{'border-primary active': $wire.sortBy === '{{$key}}'}"
                        @class(['btn bg-white rounded-pill text-primary shadow-sm py-1 px-3 me-2 text-decoration-none'])
                        for="sort-{{$key}}"
                    >{{ $sorting['name'] }}</label>
                @endforeach
            </div>

            @if (count($locationsList))
                <div class="local-group">
                    @foreach ($locationsList as $locationData)
                        @include('igniter-orange::includes.local.list-location')
                    @endforeach
                </div>

                <div class="pagination-bar text-right">
                    <div class="links">{!! $locationsList->links() !!}</div>
                </div>
            @else
                <div class="panel panel-local">
                    <div class="panel-body">
                        <p>@lang('igniter.local::default.text_filter_no_match')</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-igniter-orange::forms.form>
