---
title: igniter.orange::default.home_title
description: ''
permalink: /
layout: default

'[igniter-orange::slider]':
    code: home-slider
'[igniter-orange::local-search]': []
'[igniter-orange::featured-items]': []
---
<x-igniter-orange::slider />

<div class="border-bottom">
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-lg-6 py-5">
                @if ($this->theme->hide_search)
                    <a
                        class="btn w-100 btn-primary"
                        href="{{ restaurant_url('local/menus') }}"
                    >@lang('igniter.local::default.text_find')</a>
                @else
                    <div class="text-center">
                        <h2 class="mb-3">@lang('igniter.local::default.text_order_summary')</h2>
                        <span class="search-label sr-only">@lang('igniter.local::default.label_search_query')</span>
                    </div>
                    <div id="local-search-container">
                        <livewire:igniter-orange::local-search/>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<x-igniter-orange::featured-items/>
