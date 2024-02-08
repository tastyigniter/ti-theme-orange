<div>
    <div class="card mb-3">
        @if ($locationDefault)
            <div class="card-body">
                <h1 class="h3 card-title">{{ $locationDefault->getName() }}</h1>
                <div class="row contact-info mb-2">
                    <div class="col-1"><i class="fa fa-globe"></i></div>
                    <div class="col">{{format_address($locationDefault->getAddress())}}</div>
                </div>
                <div class="row contact-info">
                    <div class="col-1"><i class="fa fa-phone"></i></div>
                    <div class="col">{{ $locationDefault->getTelephone() }}</div>
                </div>
            </div>
        @endif
    </div>

    <div class="card">
        <div class="card-body">
            <h4 class="contact-title mb-3">@lang('igniter.frontend::default.contact.text_summary')</h4>
            @unless($message)
                @include('igniter-orange::includes.contact-form')
            @else
                <p>{{$message}}</p>
            @endunless
        </div>
    </div>
</div>
