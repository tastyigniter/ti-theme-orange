---
description: Static layout for static pages

'[session]':
    security: all

'[staticPage]':

'[staticMenu mainMenu]':
    code: main-menu

'[staticMenu footerMenu]':
    code: footer-menu

'[staticMenu pagesSideMenu]':
    code: pages-menu

'[newsletter]': {  }
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
            <div class="container py-4">
                <div id="heading" class="heading-section py-5">
                    <h2>{{ $this->page->title }}</h2>
                </div>

                <div class="row">
                    <div class="col-sm-3">
                        @themePartial('nav/pages_menu')
                    </div>

                    <div class="col-sm-9">
                        <div class="card">
                            <div class="card-body">
                                @themePage
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="footer mt-auto">
        @themePartial('footer')
    </footer>
    <div id="notification">
        @themePartial('flash')
    </div>
    @themePartial('eucookiebanner')
    @themePartial('scripts')
</body>
</html>
