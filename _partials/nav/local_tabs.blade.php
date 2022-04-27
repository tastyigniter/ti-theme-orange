<ul id="nav-tabs" class="nav-menus nav nav-tabs py-2">
    <li class="nav-item">
        <a
            @class(['nav-link rounded-pill py-1 fw-bold', 'text-muted' => $activeTab !== 'menus', 'active' => $activeTab === 'menus'])
            href="{{ restaurant_url('local/menus') }}"
        >@lang('main::lang.local.text_tab_menu')</a>
    </li>
    @if ($showReviews)
        <li class="nav-item">
            <a
                @class(['nav-link rounded-pill py-1 fw-bold', 'text-muted' => $activeTab !== 'reviews', 'active' => $activeTab === 'reviews'])
                class="nav-item nav-link {{ ($activeTab === 'reviews') ? 'active' : '' }}"
                href="{{ restaurant_url('local/reviews') }}"
            >@lang('main::lang.local.text_tab_review')</a>
        </li>
    @endif
    <li class="nav-item">
        <a
            @class(['nav-link rounded-pill py-1 fw-bold', 'text-muted' => $activeTab !== 'info', 'active' => $activeTab === 'info'])
            href="{{ restaurant_url('local/info') }}"
        >@lang('main::lang.local.text_tab_info')</a>
    </li>
    @if (isset($locationCurrent) && $locationCurrent->hasGallery())
        <li class="nav-item">
            <a
                @class(['nav-link rounded-pill py-1 fw-bold', 'text-muted' => $activeTab !== 'gallery', 'active' => $activeTab === 'gallery'])
                href="{{ restaurant_url('local/gallery') }}"
            >@lang('main::lang.local.text_tab_gallery')</a>
        </li>
    @endif
</ul>
