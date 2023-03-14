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
        'node_modules/sweetalert2/dist/sweetalert2.min.js',
        '../../app/admin/assets/src/js/vendor/waterfall.min.js',
        '../../app/admin/assets/src/js/request.js',
        '../../app/admin/assets/src/js/loader.bar.js',
        '../../app/admin/assets/src/js/loader.progress.js',
        '../../app/admin/assets/src/js/flashmessage.js',
        '../../app/admin/assets/src/js/toggler.js',
        '../../app/admin/assets/src/js/trigger.js',
        'node_modules/jquery-raty-js/lib/jquery.raty.js',
        "node_modules/currency.js/dist/currency.min.js",
        'node_modules/intl-tel-input/build/js/intlTelInput-jquery.min.js',
        'assets/src/js/app.js',
    ],
    'assets/js/app.js'
)

// We only want to copy these files when building for production
if (process.env.NODE_ENV !== 'production') return

// Copy fonts from node_modules
//
mix.copyDirectory(
    'node_modules/bootstrap/scss',
    'assets/src/scss/vendor/bootstrap'
);

mix.copy(
    'node_modules/bootstrap/dist/js/bootstrap.min.js.map',
    'assets/src/js/bootstrap.min.js.map'
).copy(
    'node_modules/jquery-raty-js/lib/jquery.raty.css',
    'assets/src/scss/vendor/jquery.raty.scss'
).copy(
    'node_modules/animate.css/animate.css',
    'assets/src/scss/vendor/animate.scss'
).copy(
    'node_modules/sweetalert2/dist/sweetalert2.min.css',
    'assets/src/scss/vendor/sweetalert2.scss'
).copy(
    'node_modules/intl-tel-input/build/css/intlTelInput.min.css',
    'assets/src/scss/vendor/intlTelInput.scss'
).copyDirectory(
    'node_modules/intl-tel-input/build/img',
    'assets/images/intlTelInput'
)
