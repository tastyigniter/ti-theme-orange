@if($data['url'])
    <figure class="mb-0">
        @if($settings['link'])<a href="{{ $settings['link'] }}">@endif
        <img
            src="{{ $data['url'] }}"
            alt="{{ $settings['alt'] }}"
            @class(['img-fluid w-100', 'rounded-4' => $settings['rounded']])
            loading="lazy"
        />
        @if($settings['link'])</a>@endif
    </figure>
@endif
