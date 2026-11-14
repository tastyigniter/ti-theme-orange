@php
    $style = in_array($settings['style'], ['primary', 'light', 'dark'], true) ? $settings['style'] : 'primary';
    $buttonClass = $style === 'primary' ? 'btn-light' : 'btn-primary';
@endphp
<div @class([
    'rounded-4 p-4 p-lg-5',
    'text-'.($settings['alignment'] ?: 'start'),
    'bg-primary text-white' => $style === 'primary',
    'bg-light' => $style === 'light',
    'bg-dark text-white' => $style === 'dark',
])>
    <h2 class="mb-2">{{ $settings['title'] }}</h2>
    @if($settings['text'])
        <p class="lead mb-0">{!! nl2br(e($settings['text'])) !!}</p>
    @endif
    @if($settings['button_text'] && $settings['button_link'])
        <a href="{{ $settings['button_link'] }}" class="btn {{ $buttonClass }} btn-lg mt-4">{{ $settings['button_text'] }}</a>
    @endif
</div>
