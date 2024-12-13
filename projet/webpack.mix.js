const mix = require('laravel-mix');

// Compiler les fichiers JS et CSS avec Mix
// Configuration de Webpack pour Laravel Mix

mix.js('resources/js/app.js', 'public/js')
   .postCss('resources/css/app.css', 'public/css', [
       require('tailwindcss'),
   ])
   .babelConfig({
    presets: ['@babel/preset-env'],
  })
   .version();

   