---
description: 'Local layout'

'[session]':
    security: all

'[pageNav]': {  }

'[newsletter]': {  }

'[localBox]':
    paramFrom: location
    showLocalThumb: 0
    menusPage: local/menus
    openTimeFormat: 'H:i'
    timePickerDateFormat: 'D d'
    timePickerTimeFormat: 'H:i'
    timePickerDateTimeFormat: 'D d H:i'

'[categories]':
    menusPage: local/menus

'[cartBox]':
    timeFormat: 'D H:i a'
    checkStockCheckout: 1
    pageIsCheckout: 0
    pageIsCart: 0
    checkoutPage: checkout/checkout

---
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?= App::getLocale(); ?>">
<head>
    <?= partial('head'); ?>
</head>
<body class="<?= $this->page->bodyClass; ?>">

    <header class="header">
        <?= partial('nav/menu'); ?>
    </header>

    <main role="main">
        <div id="page-wrapper">
            <?= partial('breadcrumb'); ?>

            <?php if (isset($this->page->heading)) { ?>
                <?= partial('heading', ['heading' => $this->page->heading]); ?>
            <?php } ?>

            <div class="container">
                <div class="row py-4">
                    <div class="col-sm-2 d-none d-sm-inline-block">
                        <div class="categories affix-categories">
                            <?= component('categories'); ?>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="content">
                            <?= component('localBox'); ?>

                            <?= page(); ?>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <?= component('cartBox'); ?>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="footer pb-4">
        <div class="footer-top">
            <?= component('newsletter'); ?>
        </div>

        <div class="footer-bottom">
            <?= partial('footer'); ?>
        </div>
    </footer>
    <div id="notification">
        <?= partial('flash'); ?>
    </div>
    <?= partial('eucookiebanner'); ?>
    <?= partial('scripts'); ?>
</body>
</html>