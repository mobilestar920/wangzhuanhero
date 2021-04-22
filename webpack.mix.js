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

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .postCss('resources/css/basic.css', 'public/css', [
        //
    ]);

mix.copy('resources/js/auth/login.js', 'public/js');
mix.copy('resources/js/manager/apps.js', 'public/js/manager');
mix.copy('resources/js/manager/customers.js', 'public/js/manager');
mix.copy('resources/js/manager/myapps.js', 'public/js/manager');
mix.copy('resources/js/manager/news.js', 'public/js/manager');
mix.copy('resources/js/manager/scripts.js', 'public/js/manager');
mix.copy('resources/js/manager/sellers.js', 'public/js/manager');
mix.copy('resources/js/manager/sellings.js', 'public/js/manager');

mix.copy('resources/js/seller/generation.js', 'public/js/seller');
mix.copy('resources/js/seller/generation.js', 'public/js/seller');

mix.copy('resources/js/jquery/jquery.dataTables.min.js', 'public/js/jquery');
mix.copy('resources/css/jquery.dataTables.min.css', 'public/css');

// Style
mix.copy('node_modules/@coreui/chartjs/dist/css/coreui-chartjs.css', 'public/css');
mix.copy('node_modules/cropperjs/dist/cropper.css', 'public/css');

// general scripts
mix.copy('node_modules/@coreui/utils/dist/coreui-utils.js', 'public/js');
mix.copy('node_modules/axios/dist/axios.min.js', 'public/js'); 
//mix.copy('node_modules/pace-progress/pace.min.js', 'public/js');  
mix.copy('node_modules/@coreui/coreui/dist/js/coreui.bundle.min.js', 'public/js'); 
mix.copy('node_modules/cropperjs/dist/cropper.js', 'public/js');

//fonts
mix.copy('node_modules/@coreui/icons/fonts', 'public/fonts');
//icons
mix.copy('node_modules/@coreui/icons/css/free.min.css', 'public/css');
mix.copy('node_modules/@coreui/icons/css/brand.min.css', 'public/css');
mix.copy('node_modules/@coreui/icons/css/flag.min.css', 'public/css');
mix.copy('node_modules/@coreui/icons/svg/flag', 'public/svg/flag');

mix.copy('node_modules/@coreui/icons/sprites/', 'public/icons/sprites');

mix.copy('resources/assets', 'public/assets');

mix.copy('node_modules/jquery/dist/jquery.min.js', 'public/js')