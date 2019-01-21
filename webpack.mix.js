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

// mix.js('resources/js/app.js', 'public/js')
//    .sass('resources/sass/app.scss', 'public/css');

   mix.styles([
      'resources/assets/layout/css/font-awesome.min.css',
      'resources/assets/layout/css/simple-line-icons.min.css',
      'resources/assets/layout/css/style.css'
  ], 'public/css/layout.css')
  .scripts([
   'resources/assets/layout/js/jquery.min.js',
   'resources/assets/layout/js/popper.min.js',
   'resources/assets/layout/js/bootstrap.min.js',
   'resources/assets/layout/js/Chart.min.js',
   'resources/assets/layout/js/pace.min.js',
   'resources/assets/layout/js/template.js',
   'resources/assets/layout/js/sweetalert2.all.js'
], 'public/js/layout.js')
.js(['resources/assets/js/app.js'],'public/js/app.js');