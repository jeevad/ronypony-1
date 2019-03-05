const mix = require('laravel-mix');

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

mix.js(['resources/js/app.js', 'resources/js/simplebar.js','resources/admin/js/script.js'], 'public/assets/admin/js')
 .js(['resources/js/app.js', 'resources/js/simplebar.js','resources/admin/js/script.js'], 'public/assets/front/js')
    .sass('resources/admin/sass/main.scss',
        'public/assets/admin/css/app.css');
    // .styles([
    //     'public/admin/css/app.css', 'public/css/simplebar.css'
    // ], 'public/admin/css/app.css');
    // .combine([
    //     'resources/sass/simplebar.css',
    //     'public/admin/css/custom.css'
    // ], 'public/admin/css/app.css');
//.sass('resources/sass/admin/main.scss', 'public/admin/css/admin.css');
