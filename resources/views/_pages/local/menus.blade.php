---
title: igniter.orange::default.menus_title
permalink: '/:location?local/menus/:category?'
description: ''
layout: default

'[igniter-orange::local-header]': []
'[igniter-orange::fulfillment]': []
'[igniter-orange::category-list]': []
'[igniter-orange::menu-item-list]': []
'[igniter-orange::cart-box]': []
'[igniter-orange::fulfillment-modal]': []
---
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
        <div class="row align-items-start">
            <div class="col-md-8">
                <x-igniter-orange::local-header/>
            </div>
            <div class="col-md-4 mt-4 mt-md-0">
                <div class="local-control float-md-end">
                    <div class="d-inline-block w-100 fs-5 text-sm-left text-md-center">
                        <x-igniter-orange::fulfillment/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="sticky-top bg-white border-bottom border-1">
    <div class="container">
        <x-igniter-orange::category-list/>
    </div>
</div>
<div class="container pt-3 pb-5">
    <div class="row">
        <div class="col-lg-8">
            <livewire:igniter-orange::menu-item-list/>
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
<livewire:igniter-orange::fulfillment-modal/>
