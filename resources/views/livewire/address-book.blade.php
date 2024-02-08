<div class="card">
    <div class="card-body">
        <div id="address-book">
            @if (!is_null($addressId))
                @include('igniter-orange::includes.account.address-book-form')
            @elseif(count($addresses))
                @include('igniter-orange::includes.account.address-book-list')
            @else
                <p>@lang('igniter.user::default.account.text_no_address')</p>
            @endif
        </div>
    </div>
</div>
