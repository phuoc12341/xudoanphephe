const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/admin/sass/app.scss', 'public/admin/css')
    .sourceMaps()
    .postCss('resources/css/app.css', 'public/css', [
    require('postcss-import'),
    require('tailwindcss'),
    require('autoprefixer'),
]);

mix.copy([
    'resources/css/util.css',
    'resources/css/main.css',
], 'public/css');

mix.copy([
    'resources/js/main.js',
], 'public/js');

mix.copy([
    'resources/js/main.js',
], 'public/js');

mix.copyDirectory('resources/fonts', 'public/fonts');

mix.copyDirectory('resources/admin/css/plugins', 'public/admin/plugins');

mix.copyDirectory('resources/admin/dist', 'public/admin/dist');
