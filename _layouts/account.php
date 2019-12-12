---
description: Account layout

'[session]':
    security: customer
    redirectPage: account/login

'[staticMenu mainMenu]':
    code: main-menu

'[staticMenu footerMenu]':
    code: footer-menu

'[account]':
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