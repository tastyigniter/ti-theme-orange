---
description: 'Account layout'
'[session]':
    security: customer
    redirectPage: account/login
'[staticMenu mainMenu]':
    code: main-menu
'[staticMenu footerMenu]':
    code: footer-menu
'[account]': null
'[localList]':
    alias: '[localList]'
    distanceUnit: km
    openingTimeFormat: 'ddd h:mm a'
'[localReview]':
    pageLimit: !!float 20
    sort: 'date_added asc'
    reviewDateFormat: 'DD MMM YY'
    reviewableType: order
    reviewableHash: '{{ :hash }}'
'[localSearch]':
    hideSearch: 0
    menusPage: home
'[localBox]':
    paramFrom: location
    redirect: home
    defaultOrderType: delivery
    hideSearch: 0
    showLocalThumb: 0
    localThumbWidth: !!float 80
    localThumbHeight: !!float 80
    menusPage: local/menus
    localBoxTimeFormat: 'h:mm a'
    openingTimeFormat: 'ddd h:mm a'
    timePickerDateFormat: 'ddd DD'
    timePickerDateTimeFormat: 'ddd DD h:mm a'
    cartBoxAlias: cartBox
---
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?= App::getLocale(); ?>">
<head>
    <?= partial('head'); ?>
</head>
<body class="<?= $this->page->bodyClass; ?>">

    <header class="header">
        <?= partial('header'); ?>
    </header>

    <main role="main">
        <div id="notification">
            <?= partial('flash'); ?>
        </div>

        <div id="page-wrapper">
            <?= page(); ?>
        </div>
    </main>

    <footer class="pt-5">
        <?= partial('footer'); ?>
    </footer>
    <div id="notification">
        <?= partial('flash'); ?>
    </div>
    <?= partial('scripts'); ?>
</body>
</html>