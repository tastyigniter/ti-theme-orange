---
title: 'main::default.home.title'
permalink: /
description: ''
layout: default

'[account]':
    accountPage: account/account
    detailsPage: account/details
    addressPage: account/address
    ordersPage: account/orders
    reservationsPage: account/reservations
    reviewsPage: account/reviews
    inboxPage: account/inbox
    redirectPage: account/account
    loginPage: account/login

'[slider]': {  }

'[localSearch]':
    hideSearch: 0
    menusPage: local/menus

'[featuredItems]':
    items: ['76', '77', '78', '79']
    limit: 3
    itemsPerRow: 3
    itemWidth: 400
    itemHeight: 300

---
<?php
function onInit() {
}

function onStart() {
}

function onEnd() {
}
?>
---
<?= component('slider'); ?>

<?= component('localSearch'); ?>

<?= component('featuredItems'); ?>