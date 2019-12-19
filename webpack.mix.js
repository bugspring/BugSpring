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

mix.options({
    hmrOptions: {
        host: 'bugspring.test',  // site's host name
        port: '8080'
    }
});


//mix.setPublicPath('public');
//mix.setResourceRoot('../');
mix.js('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css')
    .copyDirectory('node_modules/@mdi/font/fonts', 'public/fonts/vendor/@mdi')
   .sourceMaps();
