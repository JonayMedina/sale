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

mix.styles([
	'resources/template/css/font-awesome.min.css',
	'resources/template/css/simple-line-icons.min.css',
	'resources/template/css/style.css'
	], 'public/css/template.css')
	.scripts([
	'resources/template/js/sweetalert2.all.min.js',
	'resources/template/js/jquery.min.js',
	'resources/template/js/popper.min.js',
	/*'resources/template/js/bootstrap.min.js',*/
	'resources/template/js/Chart.min.js',
	'resources/template/js/pace.min.js',
	'resources/template/js/template.js',
	
	], 'public/js/template.js')

mix.js('resources/js/app.js', 'public/js');
