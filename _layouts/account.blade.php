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
<html xmlns="http://www.w3.org/1999/xhtml" lang="{{ App::getLocale() }}" class="h-100">
<head>
    @themePartial('head')
</head>
<body class="d-flex flex-column h-100 {{ $this->page->bodyClass }}">

    <header class="header">
        @themePartial('header')
    </header>

    <main role="main">
        <div id="notification">
            @themePartial('flash')
        </div>

        <div id="page-wrapper">
            @page
        </div>
    </main>

    <footer class="footer mt-auto">
        @themePartial('footer')
    </footer>
    <div id="notification">
        @themePartial('flash')
    </div>
    @themePartial('scripts')
</body>
</html>
