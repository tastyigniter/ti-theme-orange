---
description: 'Local layout'
'[session]':
    loginPage: account/login
    redirectPage: local/menus
'[staticMenu mainMenu]':
    code: main-menu
'[staticMenu footerMenu]':
    code: footer-menu
'[newsletter]': {  }
'[localBox]':
    paramFrom: location
    showLocalThumb: 0
    menusPage: local/menus
'[categories]':
    menusPage: local/menus
'[cartBox]':
    checkStockCheckout: 1
    showCartItemThumb: 1
    pageIsCheckout: 0
    pageIsCart: 0
    checkoutPage: checkout/checkout
'[localList]':
    distanceUnit: km
    openingTimeFormat: 'ddd h:mm a'
'[localBox localBoxCopy]':
    alias: '[localBox]'
    paramFrom: location
    redirect: home
    defaultOrderType: delivery
    hideSearch: null
    showLocalThumb: 0
    localThumbWidth: 80
    localThumbHeight: 80
    menusPage: local/menus
    localBoxTimeFormat: 'h:mm a'
    openingTimeFormat: 'ddd h:mm a'
    timePickerDateFormat: 'ddd DD'
    timePickerDateTimeFormat: 'ddd DD h:mm a'
    cartBoxAlias: cartBox
'[localSearch]':
    alias: '[localSearch]'
    hideSearch: null
    menusPage: local/menus
'[booking]':
    alias: '[booking]'
    mode: true
    maxGuestSize: 20
    datePickerNoOfDays: 30
    timePickerInterval: 30
    timeSlotsInterval: 15
    bookingDateFormat: 'MMM DD, YYYY'
    bookingTimeFormat: 'hh:mm a'
    bookingDateTimeFormat: 'dddd, MMMM D, YYYY \a\t hh:mm a'
    showLocationThumb: null
    locationThumbWidth: 95
    locationThumbHeight: 80
    bookingPage: reservation/reservation
    successPage: reservation/success
'[accountReservations]':
    itemsPerPage: !!float 20
    reservationDateTimeFormat: 'DD MMM \a\t h:mm a'
    hashParamName: hash
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
        <div id="page-wrapper">
            <div class="container-fluid">
                <?php if ($location->getModel()->hasMedia('page_banner')) { ?>
                                              <img class="img-responsive img-fluid" style="height: 240px; border-radius: 4px;"
                                 src="<?= $location->getModel()->getThumb([
                                     'width' => 1400,
                                     'height' => 240,
                                 ], 'page_banner'); ?>">
                <?php } ?>
                <div class="row py-4">
                    <div class="col-sm-2 d-none d-sm-inline-block">
<!--                        <div class="categories affix-categories smoova-category-item">-->
                        <div class="categories smoova-category-item">
                            <?= component('categories'); ?>
                        </div>
                    </div>

                    <div class="col-sm-7">
                        <div class="content">
                            <?= component('localBox'); ?>

                            <?= page(); ?>
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <?= partial('cartBox/container'); ?>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="pt-5">
        <?= partial('footer'); ?>
    </footer>
    <div id="notification">
        <?= partial('flash'); ?>
    </div>
    <?= partial('eucookiebanner'); ?>
    <?= partial('scripts'); ?>
</body>
</html>