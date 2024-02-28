---
title: 'main::lang.local.menus.title'
permalink: '/:location?local/menus/:category?'
description: ''
layout: default
---
<?php

function onStart()
{
    if (request()->route()->parameter('location') !== Location::current()->permalink_slug) {
        return redirect()->to(page_url('home'));
    }

    if ((!Location::current()?->isEnabled() && !AdminAuth::getUser()?->hasPermission('Admin.Locations'))) {
        flash()->error(lang('igniter.local::default.alert_location_required'));
        return redirect()->to(page_url('home'));
    }
}
?>
---
<div>
    <div class="bg-white border-bottom border-1">
        <div class="container py-4">
            <div class="mb-3" wire:ignore>
                <a
                    class="text-decoration-none"
                    href="{{page_url('locations')}}"
                >
                    <i class="fa fa-arrow-left-long"></i>&nbsp;&nbsp;
                    @lang('igniter.orange::default.button_back')
                </a>
            </div>
            <div class="row align-items-end">
                <div class="col-md-8">
                    <x-igniter-orange::local-header />
                </div>
                <div class="col-md-4 mt-4 mt-md-0">
                    <div class="local-control float-md-end">
                        <div class="d-inline-block rounded py-3 px-3 bg-light text-sm-left text-md-center">
                            <x-igniter-orange::local-control />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="bg-white border-bottom border-1">
        <div class="container">
            <x-igniter-orange::categories-list/>
        </div>
    </div>
    <div class="container pt-3 pb-5">
        <div class="row">
            <div class="col-lg-8">
                <livewire:igniter-orange::menu-items-list />
            </div>

            <div class="col-lg-4 d-none d-lg-inline-block">
                <livewire:igniter-orange::cart-box/>
            </div>
        </div>
    </div>
    <div class="fixed-bottom d-block d-lg-none">
        <a
            class="btn btn-primary w-100 btn-lg radius-none cart-toggle text-nowrap"
            href="{{ page_url('cart') }}"
        >
            @lang('igniter.orange::default.button_view_cart'):
            <span class="fw-bold">{{ currency_format(Cart::total()) }}</span>
        </a>
    </div>
    <livewire:igniter-orange::fulfillment-modal />
</div>
