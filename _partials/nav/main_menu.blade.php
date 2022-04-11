<ul class="nav navbar-nav">
    @foreach ($items as $navItem)
        @continue(Auth::isLogged() && in_array($navItem->code, ['login', 'register']))
        @continue(!Auth::isLogged() && in_array($navItem->code, ['account', 'recent-orders']))
        <li
            @class(['nav-item', 'dropdown' => $navItem->items])
        >
            <a
                @class(['nav-link', 'dropdown-toggle' => $navItem->items, 'active text-primary' => $navItem->isActive || $navItem->isChildActive])
                href="{{ $navItem->items ? '#' : $navItem->url }}"
                @if ($navItem->items) data-bs-toggle="dropdown" @endif
                {!! $navItem->extraAttributes !!}
            >@lang($navItem->title) @if ($navItem->items) <span class="caret"></span> @endif</a>
            @if ($navItem->items)
                <div
                    class="dropdown-menu px-3"
                    aria-labelledby="navbar-{{ $navItem->code }}"
                    role="menu"
                >
                    @foreach ($navItem->items as $item)
                        <a
                            @class(['dropdown-item py-2 rounded', 'active' => $item->isActive, 'border-bottom' => !$loop->last])
                            href="{{ $item->url }}"
                            {!! $item->extraAttributes !!}
                        >@lang($item->title)</a>
                    @endforeach
                </div>
            @endif
        </li>
    @endforeach
</ul>
