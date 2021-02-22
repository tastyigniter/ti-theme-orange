<div class="py-5">
    <div class="container">
        <div class="row">
            @foreach ($footerMenu->menuItems() as $navItem)
                <div class="col-sm-3">
                    <div class="footer-links">
                        <h6 class="footer-title d-none d-sm-block">@lang($navItem->title)</h6>
                        <ul>
                            @foreach ($navItem->items as $item)
                                <li>
                                    <a
                                        href="{{ $item->url }}"
                                        {!! $item->extraAttributes !!}
                                    >@lang($item->title)</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endforeach

            <div class="col-sm-3 mt-3 mt-sm-0">
                <div class="social-bottom">
                    <h6 class="footer-title">@lang('main::lang.text_follow_us')</h6>
                    @partial('social_icons', ['socialIcons' => $this->theme->social])
                </div>
            </div>

            @if (has_component('newsletter'))
                <div class="col-sm-3 mt-3 mt-sm-0">
                    <div id="newsletter-box">
                        <h5 class="mb-4">@lang('igniter.frontend::default.newsletter.text_subscribe')</h5>
                        @component('newsletter')
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col">
                <hr class="mb-3">
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col p-2">
                {!! sprintf(
                    lang('main::lang.site_copyright'),
                    date('Y'),
                    setting('site_name'),
                    lang('system::lang.system_name')
                ).lang('system::lang.system_powered') !!}
            </div>
        </div>
    </div>
</div>
