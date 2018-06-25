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

 mix.scripts([
 	'resources/assets/js/main.js',
 	'resources/assets/js/employees.js',
 	'resources/assets/js/objects.js'
 	], 'public/js/main.min.js')
 .styles([
 	'resources/assets/sass/main.scss',
 	'resources/assets/sass/service.scss',
 	'resources/assets/sass/employees.scss',
 	'resources/assets/sass/gallery.scss',
 	'resources/assets/sass/objects.scss',
 	'resources/assets/sass/news.scss',
 	'resources/assets/sass/media.scss'
 	], 'public/css/main.min.css');
