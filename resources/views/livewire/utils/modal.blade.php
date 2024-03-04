<div>
    <div
        x-data="OrangeModal()"
        x-show="show"
        x-on:close.stop="setShowPropertyTo(false)"
    >
        @forelse($components as $id => $component)
            <div
                x-ref="{{ $id }}"
                wire:key="{{ $id }}"
                id="modal-{{ $id }}"
                class="modal fade"
                role="dialog"
                tabindex="-1"
                aria-labelled="modal-{{ $id }}"
                aria-hidden="true"
            >
                @livewire($component['name'], $component['arguments'], key($id))
            </div>
        @empty
            <div
                :class="{ 'd-block show': show }"
                id="modal-loading"
                class="modal fade bg-dark opacity-75"
                role="dialog"
                tabindex="-1"
                aria-labelled="modal-loading"
                aria-hidden="true"
            >
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="text-center">
                                <div class="ti-loading spinner-border fa-3x fa-fw" role="status"></div>
                                <div class="fw-bold mt-2">Loading...</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforelse
    </div>
</div>
