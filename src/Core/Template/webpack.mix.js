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

mix
    .js('./vendor/msllp/core/src/Views/core/B/s/js/app.js', 'public/b/js')
   .sass('./vendor/msllp/core/src/Views/core/B/s/css/app.scss', 'public/b/css');
