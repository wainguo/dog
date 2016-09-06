var elixir = require('laravel-elixir');
require('./elixir-extensions');

elixir(function(mix) {
 mix
     //.phpUnit()
     //.compressHtml()

    /**
     * Copy needed files from /node directories
     * to /public directory.
     */
     .copy(
       'node_modules/font-awesome/fonts',
       'public/build/fonts/font-awesome'
     )
     .copy(
       'node_modules/bootstrap-sass/assets/fonts/bootstrap',
       'public/build/fonts/bootstrap'
     )
     .copy(
         'semantic/dist/themes',
         'public/build/css/themes'
     )
     .copy(
       'node_modules/bootstrap-sass/assets/javascripts/bootstrap.min.js',
       'public/js/vendor/bootstrap'
     )
     //guoshengxing added
     .copy(
         'node_modules/slick-carousel/slick',
         'public/vendor/slick'
     )
     .copy(
         'node_modules/vue/dist/vue.min.js',
         'public/js/vendor/vue'
     )
     .copy(
         'node_modules/vue-resource/dist/vue-resource.min.js',
         'public/js/vendor/vue'
     )
     .copy(
         'semantic/dist/semantic.min.js',
         'resources/assets/js/frontend'
     )
     .copy(
         'semantic/dist/semantic.min.css',
         'resources/assets/css/frontend'
     )
     //add end

     /**
      * Process backend SCSS stylesheets
      */
     .sass([
         'backend/app.scss',
         'backend/plugin/toastr/toastr.scss',
         'plugin/sweetalert/sweetalert.scss'
     ], 'resources/assets/css/backend/app.css')

     /**
      * Combine pre-processed backend CSS files
      */
     .styles([
         'backend/app.css'
     ], 'public/css/backend.css')

     /**
      * Make RTL (Right To Left) CSS stylesheet for the backend
      */
     .rtlCss()

     /**
      * Combine backend scripts
      */
     .scripts([
         'plugin/sweetalert/sweetalert.min.js',
         'plugins.js',
         'backend/app.js',
         'backend/plugin/toastr/toastr.min.js',
         'backend/custom.js'
     ], 'public/js/backend.js')

     /**
      * Combine pre-processed rtl CSS files
      */
     .styles([
         'rtl/bootstrap-rtl.css'
     ], 'public/css/rtl.css')

     /**
      * Process frontend SCSS stylesheets
      */
     // .sass([
     //    'frontend/app.scss',
     //    'plugin/sweetalert/sweetalert.scss'
     // ], 'resources/assets/css/frontend/app.css')

     .sass([
         'plugin/sweetalert/sweetalert.scss'
     ], 'resources/assets/css/frontend/sweetalert.css')

     /**
      * Combine pre-processed frontend CSS files
      */
     // .styles([
     //    'frontend/app.css'
     // ], 'public/css/frontend.css')
     .styles([
         'frontend/semantic.min.css',
         'frontend/sweetalert.css'
     ], 'public/css/frontend.css')

     /**
      * Combine frontend scripts
      */
     // .scripts([
     //    'plugin/sweetalert/sweetalert.min.js',
     //    'plugins.js',
     //    'frontend/app.js'
     // ], 'public/js/frontend.js')
     .scripts([
         'plugin/sweetalert/sweetalert.min.js',
         'frontend/semantic.min.js'
     ], 'public/js/frontend.js')



    /**
      * Apply version control
      */
     .version([
         "public/css/frontend.css",
         "public/js/frontend.js",
         "public/css/backend.css",
         "public/css/backend-rtl.css",
         "public/js/backend.js",
         "public/css/rtl.css"
     ]);
});