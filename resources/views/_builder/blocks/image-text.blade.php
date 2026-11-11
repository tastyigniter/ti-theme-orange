<div class="row g-4 align-items-center">
    <div @class(['col-md-6', 'order-md-last' => $settings['image_position'] === 'end'])>
        @if($data['url'])
            <img src="{{ $data['url'] }}" alt="{{ $settings['title'] }}" class="img-fluid w-100 rounded-4" loading="lazy"/>
        @endif
    </div>
    <div class="col-md-6">
        @if($settings['title'])
            <h2 class="mb-3">{{ $settings['title'] }}</h2>
        @endif
        <div class="page-content">
            {!! $settings['content'] !!}
        </div>
        @if($settings['button_text'] && $settings['button_link'])
            <a href="{{ $settings['button_link'] }}" class="btn btn-primary mt-3">{{ $settings['button_text'] }}</a>
        @endif
    </div>
</div>
