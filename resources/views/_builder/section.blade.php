@php
    $settings = $section['settings'];
    $spacing = ['none' => '', 'sm' => 'py-3', 'md' => 'py-4', 'lg' => 'py-5'][$settings['spacing']] ?? 'py-4';
    $styles = [];
    if ($settings['background_color'] && preg_match('/^(#[0-9a-fA-F]{3,8}|rgba?\([\d\s.,%]+\))$/', $settings['background_color'])) {
        $styles[] = 'background-color: '.$settings['background_color'];
    }
    if ($settings['background_image']) {
        $styles[] = "background-image: url('".e(media_url($settings['background_image']))."')";
        $styles[] = 'background-size: cover';
        $styles[] = 'background-position: center';
    }
    $sectionId = $settings['anchor'] ? str_slug($settings['anchor']) : $section['id'];
    // HTML attributes entered for the section; an id or style there wins over the anchor and background.
    $attributes = $section['attributes'] ?? [];
    $sectionId = $attributes['id'] ?? $sectionId;
    if (!empty($attributes['style'])) {
        $styles[] = $attributes['style'];
    }
@endphp
<section
    id="{{ $sectionId }}"
    @class(['page-section', $spacing, $settings['css_class']])
    @if($styles) style="{{ implode('; ', $styles) }}" @endif
    {!! \Igniter\Main\Classes\HtmlAttributes::toHtml(array_except($attributes, ['id', 'class', 'style'])) !!}
>
    <div @class(['container' => $settings['container'] === 'boxed'])>
        <div @class([
            'row',
            'g-0' => $settings['container'] === 'full',
            'g-4' => $settings['container'] !== 'full',
        ])>
            @foreach($section['columns'] as $column)
                <div @class([
                    'col-12',
                    'col-lg' => $section['equal'] && $column['span'] === null,
                    'col-lg-'.$column['span'] => $column['span'] !== null,
                    'd-none d-lg-block' => empty($column['blocks']),
                ])>
                    @foreach($column['blocks'] as $block)
                        {{-- A block's CSS class and HTML attributes go on an element around it. --}}
                        @if(!empty($block['attributes']))
                            <div {!! \Igniter\Main\Classes\HtmlAttributes::toHtml($block['attributes']) !!}>{!! $renderBlock($block) !!}</div>
                        @else
                            {!! $renderBlock($block) !!}
                        @endif
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
</section>
