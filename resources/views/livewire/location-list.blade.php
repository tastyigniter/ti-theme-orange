<div>
    <div class="row">
        <div class="col-sm-3">
            @if ($searchQueryPosition->isValid())
                <div class="d-flex bg-white border rounded p-3 mb-3">
                    <h5 class="mb-0 d-inline-block flex-grow-1">
                        <i class="fa fa-map-marker"></i>&nbsp;&nbsp;
                        {{ $searchQueryPosition->getLocality() }}
                    </h5>
                    <a
                        role="button"
                        class="text-primary"
                        data-bs-toggle="modal"
                        data-bs-target="#localControlModal"
                    >@lang('igniter.local::default.search.text_change')</a>
                </div>
            @endif
            <div class="bg-white border rounded p-3 mb-3">
                @include('igniter-orange::includes.local.list-filter-items', ['filters' => $this->orderTypes, 'field' => 'orderType'])
            </div>
            <div class="bg-white border rounded p-3 mb-3">
                @include('igniter-orange::includes.local.list-filters', ['filters' => $this->sorters, 'field' => 'sortBy'])
            </div>
        </div>
        <div class="col-sm-9">
            <div class="mb-4">
                @include('igniter-orange::includes.local.list-search')
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
    <livewire:igniter-orange::fulfillment-modal/>
</div>
