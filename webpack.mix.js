let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */
//
// Copy fonts from node_modules
//
mix.copyDirectory(
    'node_modules/@fortawesome/fontawesome-free-webfonts/webfonts',
    'assets/fonts/FontAwesome'
);

//
//  Build SCSS
//
mix.sass('assets/src/scss/app.scss', 'assets/css/');

mix.styles(
    [
        'node_modules/jquery-raty-js/lib/jquery.raty.css',
    ],
    'assets/css/vendor/vendor.css')

//
//  Combine Vendor JS
//
mix.scripts(
    [
        'node_modules/jquery/dist/jquery.min.js',
        'node_modules/popper.js/dist/umd/popper.min.js',
        'node_modules/bootstrap/dist/js/bootstrap.min.js',
        'node_modules/select2/dist/js/select2.min.js',
        'node_modules/jquery-raty-js/lib/jquery.raty.js',
        'assets/js/vendor/affix.js',
    ],
    'assets/js/vendor/vendor.js')

// Maps
mix.copy(
    'node_modules/bootstrap/dist/js/bootstrap.min.js.map',
    'assets/js/vendor/bootstrap.min.js.map'
).copy(
    'node_modules/popper.js/dist/umd/popper.min.js.map',
    'assets/js/vendor/popper.min.js.map'
)

//
//  Combine UI JS
//
// mix.scripts(
//     [
        // '../../core/app/system/assets/ui/js/flame.js', // node_modules
        // 'assets/js/common.js',
    // ],
    // 'assets/js/app.js')
