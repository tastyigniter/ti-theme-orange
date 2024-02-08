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
<livewire:igniter-orange::pages.local-menu/>
