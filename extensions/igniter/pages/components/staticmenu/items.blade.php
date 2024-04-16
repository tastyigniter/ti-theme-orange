@foreach ($items as $item)
    <li
        role="presentation"
        class="{{ $item->isActive ? 'active' : '' }} {{ $item->isChildActive ? 'child-active' : '' }}">
        @if ($item->url)
            <a
                href="{{ $item->url }}"
                {!! isset($item->config['isExternal']) ? 'target="_blank"' : '' !!}
            >{{ $item->title }}</a>
        @else
            <span>{{ $item->title }}</span>
        @endif

        @if ($item->items)
            <ul>
                @partial($__SELF__.'::items', ['items' => $item->items])
            </ul>
        @endif
    </li>
@endforeach