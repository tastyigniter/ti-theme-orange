<ul id="nav-tabs" class="nav-menus nav nav-tabs">
    <a
        class="nav-item nav-link {{ ($activeTab === 'menus') ? 'active' : '' }}"
        href="{{ restaurant_url('local/menus') }}"
    >@lang('main::lang.local.text_tab_menu')</a>
    @if ($showReviews)
        <a
            class="nav-item nav-link {{ ($activeTab === 'reviews') ? 'active' : '' }}"
            href="{{ restaurant_url('local/reviews') }}"
        >@lang('main::lang.local.text_tab_review')</a>
    @endif
    <a
        class="nav-item nav-link {{ ($activeTab === 'info') ? 'active' : '' }}"
        href="{{ restaurant_url('local/info') }}"
    >@lang('main::lang.local.text_tab_info')</a>
    @if (isset($locationCurrent) AND $locationCurrent->hasGallery())
        <a
            class="nav-item nav-link {{ ($activeTab === 'gallery') ? 'active' : '' }}"
            href="{{ restaurant_url('local/gallery') }}"
        >@lang('main::lang.local.text_tab_gallery')</a>
    @endif
</ul>