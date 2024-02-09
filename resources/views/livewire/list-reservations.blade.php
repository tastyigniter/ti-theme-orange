<div>
    @if ($reservation)
        @if ($allowReviews && !empty($reviewable))
            <div class="mb-3">
                <livewire:igniter-orange::leave-review />
            </div>
        @endif

        @include('igniter-orange::includes.account.show-reservation')
    @elseif(count($reservations))
        @include('igniter-orange::includes.account.list-reservations')
    @else
        <p>@lang('igniter.reservation::default.text_empty')</p>
    @endif
</div>
