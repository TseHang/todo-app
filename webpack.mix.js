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

//  Mix run 'Auto-prefixer', Es6, basically.
mix
  .sass('resources/assets/sass/tasks.scss', 'public/css', {
    includePaths: [`${__dirname}/node_modules/normalize-scss/sass`],
  })
  .sass('resources/assets/sass/app.scss', 'public/css', {
    includePaths: [`${__dirname}/node_modules/normalize-scss/sass`],
  });

mix
  .js('resources/assets/js/tasks.js', 'public/js')
  .js('resources/assets/js/message.js', 'public/js');
