let mix = require('laravel-mix');

mix.setPublicPath('./').options({
    processCssUrls: false,
})

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your TastyIgniter application. By default, we are copying all the
 | dependencies for the theme into the assets folder.
 | Compilation is done by the theme customizer in the Admin Panel.
 |
 */
//
// Copy fonts from node_modules
//
// mix.copyDirectory(
//     'node_modules/bootstrap/scss',
//     'assets/src/scss/vendor/bootstrap'
// );
//
// mix.copy(
//     'node_modules/bootstrap/dist/js/bootstrap.min.js.map',
//     'assets/src/js/bootstrap.min.js.map'
// ).copy(
//     'node_modules/jquery-raty-js/lib/jquery.raty.css',
//     'assets/src/scss/vendor/jquery.raty.scss'
// ).copy(
//     'node_modules/animate.css/animate.css',
//     'assets/src/scss/vendor/animate.scss'
// )

//
//  Build SCSS
//
// Leave commented to use the admin theme customizer to compile your assets,
// or uncomment to use webpack to compile
//
mix.sass('assets/src/scss/app.scss', 'assets/css/');

//
//  Combine Vendor JS
//
// Leave commented to use the theme customizer to compile your assets,
// or uncomment to use webpack to compile
//
mix.scripts(
    [
        'node_modules/jquery/dist/jquery.min.js',
        'node_modules/@popperjs/core/dist/umd/popper.min.js',
        'node_modules/bootstrap/dist/js/bootstrap.min.js',
        'node_modules/sweetalert/dist/sweetalert.min.js',
        '../../app/system/assets/ui/js/vendor/waterfall.min.js',
        '../../app/system/assets/ui/js/vendor/transition.js',
        '../../app/system/assets/ui/js/app.js',
        '../../app/system/assets/ui/js/loader.bar.js',
        '../../app/system/assets/ui/js/loader.progress.js',
        '../../app/system/assets/ui/js/flashmessage.js',
        '../../app/system/assets/ui/js/toggler.js',
        '../../app/system/assets/ui/js/trigger.js',
        'node_modules/jquery-raty-js/lib/jquery.raty.js',
        "node_modules/currency.js/dist/currency.min.js",
        'assets/src/js/app.js',
    ],
    'assets/js/app.js'
)
