@php($tag = in_array($settings['level'], ['h1', 'h2', 'h3', 'h4'], true) ? $settings['level'] : 'h2')
<div class="text-{{ $settings['alignment'] ?: 'start' }} mb-3">
    <{{ $tag }} class="mb-2">{{ lang($settings['title']) }}</{{ $tag }}>
    @if($settings['subtitle'])
        <p class="lead text-muted mb-0">{!! nl2br(e(lang($settings['subtitle']))) !!}</p>
    @endif
</div>
