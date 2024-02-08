---
title: main::lang.account.reset.title
layout: default
permalink: /forgot-password/:code?
security: guest
---
<div class="container">
    <div class="row">
        <div class="col-sm-6 mx-auto my-5">
            <div class="card">
                <div class="card-body">
                    <h1 class="card-title h4 mb-4 font-weight-normal">
                        @lang('main::lang.account.reset.text_heading')
                    </h1>

                    <livewire:igniter-orange::reset-password />
                </div>
            </div>
        </div>
    </div>
</div>
