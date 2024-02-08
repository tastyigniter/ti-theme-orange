---
title: main::lang.cart.title
layout: default
permalink: /cart
---
<div class="container">
    <div class="row py-4">
        <div class="col col-lg-6 m-auto">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="mb-3" wire:ignore>
                        <a
                            wire:navigate
                            class="text-decoration-none"
                            href="{{page_url('local/menus')}}"
                        >
                            <i class="fa fa-arrow-left-long"></i>&nbsp;&nbsp;
                            @lang('igniter.orange::default.button_back')
                        </a>
                    </div>
                    <x-igniter-orange::show-local-info />
                </div>
            </div>
            <livewire:igniter-orange::cart-box />
        </div>
    </div>
</div>
