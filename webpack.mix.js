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
mix.copyDirectory(
    'node_modules/@fortawesome/fontawesome-free/webfonts',
    'assets/fonts/FontAwesome'
).copyDirectory(
    'node_modules/@fortawesome/fontawesome-free/scss',
    'assets/src/scss/vendor/FontAwesome'
).copyDirectory(
    'node_modules/bootstrap/scss',
    'assets/src/scss/vendor/bootstrap'
);

mix.copy(
    'node_modules/bootstrap/dist/js/bootstrap.min.js.map',
    'assets/src/js/bootstrap.min.js.map'
).copy(
    'node_modules/select2/dist/js/select2.min.js',
    'assets/src/js/vendor/select2.min.js'
).copy(
    'node_modules/jquery-raty-js/lib/jquery.raty.js',
    'assets/src/js/vendor/jquery.raty.js'
).copy(
    'node_modules/jquery-raty-js/lib/jquery.raty.css',
    'assets/src/scss/vendor/jquery.raty.scss'
).copy(
    'node_modules/animate.css/animate.css',
    'assets/src/scss/vendor/animate.scss'
).copy(
    'node_modules/select2-theme-bootstrap4/src/select2-bootstrap.scss',
    'assets/src/scss/vendor/select2-bootstrap.scss'
)

//
//  Build SCSS
//
// Leave commented to use the admin theme customizer to compile your assets,
// or uncomment to use webpack to compile
//
// mix.sass('assets/src/scss/app.scss', 'assets/css/');

//
//  Combine Vendor JS
//
// Leave commented to use the theme customizer to compile your assets,
// or uncomment to use webpack to compile
//
// mix.scripts(
//     [
//         '../../core/app/system/assets/ui/flame.js',
//         'assets/src/js/vendor/select2.min.js',
//         'assets/src/js/vendor/jquery.raty.js',
//         'assets/src/js/vendor/affix.js',
//         'assets/src/js/app.js',
//     ],
//     'assets/js/app.js')
