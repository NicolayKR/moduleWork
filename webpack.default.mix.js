let mix = require('laravel-mix');
mix.js('resources/js/app.js', 'public/js')
    .vue()
    .sass('resources/sass/app.scss', 'public/css');

// Если не нужен сервер статики, закомментировать...
// const browserSync = require("browser-sync").create();
// browserSync.init({
//     watch: true,
//     server: "./dist"
// });