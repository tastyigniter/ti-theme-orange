---
description: 'Local layout'

'[session]':
    security: all

'[staticMenu mainMenu]':
    code: main-menu

'[staticMenu footerMenu]':
    code: footer-menu

'[newsletter]': {  }

'[localSearch]':

'[localBox]':
    paramFrom: location
    showLocalThumb: 0

'[categories]':

'[cartBox]':
    checkStockCheckout: 1
    showCartItemThumb: 1
    pageIsCheckout: 0
    pageIsCart: 0

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

    <main role="main" class="page-pt">
        <div id="page-wrapper">
            <div class="container">
                <div class="row py-4">
                    <div class="col-lg-2 d-none d-lg-inline-block">
                        <div class="categories affix-categories">
                            @componentPartial('categories')
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="content">
                            @themePartial('localBox::container')

                            @themePage
                        </div>
                    </div>

                    <div class="col-lg-4">
                        @themePartial('cartBox::container')
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="footer mt-auto d-none d-lg-block">
        @themePartial('footer')
    </footer>
    <div id="notification">
        @themePartial('flash')
    </div>
    @themePartial('eucookiebanner')
    @themePartial('scripts')
</body>
</html>
