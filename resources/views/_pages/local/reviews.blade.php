---
title: igniter.orange::default.reviews_title
permalink: '/:location?local/reviews'
description: ''
layout: default

'[igniter-orange::local-header]': []
'[igniter-orange::review-list]': []
'[igniter-orange::cart-box]': []
---
<?php
function onStart()
{
    if (request()->route()->parameter('location') !== \Igniter\Local\Facades\Location::current()->permalink_slug) {
        return redirect()->to(page_url('home'));
    }

    if (!\Igniter\Local\Models\ReviewSettings::allowReviews()) {
        flash()->error(lang('igniter.local::default.review.alert_review_disabled'));
        return redirect()->to(page_url('home'));
    }

    return null;
}
?>
---
@themeBlocks
