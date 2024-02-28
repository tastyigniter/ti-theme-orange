---
title: 'main::lang.local.menus.title'
permalink: '/:location?local/reviews'
description: ''
layout: default
---
<?php

function onStart()
{
    if (request()->route()->parameter('location') !== Location::current()->permalink_slug) {
        return redirect()->to(page_url('home'));
    }

    if (!\Igniter\Local\Models\ReviewSettings::allowReviews()) {
        flash()->error(lang('igniter.local::default.review.alert_review_disabled'));
        return redirect()->to(page_url('home'));
    }
}
?>
---
<livewire:igniter-orange::reviews-list />
