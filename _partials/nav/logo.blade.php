<a class="navbar-brand" href="{{ page_url('home') }}">
    @if ($this->theme->logo_image)
        <img
            class="img-logo"
            alt="{{ setting('site_name') }}"
            src="{{ uploads_url($this->theme->logo_image) }}"
        />
    @elseif ($this->theme->logo_text)
        <span class="text-logo">{{ $this->theme->logo_text }}</span>
    @else
        <img
            class="img-logo"
            alt="{{ setting('site_name') }}"
            src="{{ uploads_url(setting('site_logo')) }}"
        />
    @endif
</a>
