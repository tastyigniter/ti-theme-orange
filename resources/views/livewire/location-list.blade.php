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
                        data-bs-target="#fulfillmentModal"
                    >@lang('igniter.local::default.search.text_change')</a>
                </div>
            @endif
            <div class="bg-white border rounded p-3 mb-3">
                @include('igniter-orange::includes.local.list-filter-items', ['filters' => $this->orderTypes, 'field' => 'orderType'])
            </div>
            <div class="bg-white border rounded p-3 mb-3">
                <div
                    role="button"
                    class="bg-white accordion-button shadow-none p-0 fw-bold"
                    data-bs-toggle="collapse"
                    data-bs-target="#collapseExample"
                    aria-expanded="false"
                    aria-controls="collapseExample"
                >@lang('igniter.orange::default.text_sort')</div>
                <div class="collapse show" id="collapseExample">
                    <div class="pt-3">
                        @include('igniter-orange::includes.local.list-filter-items', ['filters' => $this->sorters, 'field' => 'sortBy'])
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-9">
            <div class="mb-4">
                <div class="input-group input-group-lg bg-white rounded border p-1 mb-3 mb-lg-0">
                    <input
                        wire:model.live="search"
                        wire:loading.attr="disabled"
                        type="search"
                        class="bg-white form-control shadow-none border-none"
                        name="search"
                        placeholder="@lang('igniter.local::default.text_filter_search')"
                    />
                    <button
                        class="btn btn-secondary btn-lg fw-bold ms-lg-3 rounded"
                        type="button"
                    ><i class="fa fa-search"></i></button>
                </div>
            </div>

            @if (count($locationsList))
                <div class="local-group">
                    @foreach ($locationsList as $locationData)
                        @include('igniter-orange::includes.local.location-card')
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
</div>
