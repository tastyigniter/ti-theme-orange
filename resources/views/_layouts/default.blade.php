---
description: Default layout
---
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="{{ App::getLocale() }}" class="h-100">
<head>
    @include('igniter-orange::includes.head')
    @livewireStyles
</head>
<body class="d-flex flex-column h-100 {{ $this->page->bodyClass }}">

<header class="header">
    @include('igniter-orange::includes.header')
</header>

<main role="main">
    <div id="page-wrapper">
        @themePage
    </div>
</main>

<footer class="footer mt-auto">
    @include('igniter-orange::includes.footer')
</footer>
<livewire:igniter-orange::modal />
<livewire:igniter-orange::offcanvas />
<div id="notification">
    @include('igniter-orange::includes.flash')
</div>
@include('igniter-orange::includes.eucookiebanner')
@livewireScripts
@include('igniter-orange::includes.scripts')
</body>
</html>
