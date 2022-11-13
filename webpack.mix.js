let mix = require('laravel-mix');


mix.setPublicPath('sisgea/')
.styles([
    'resources/plantilla/css/font-awesome.min.css',
    'resources/plantilla/css/simple-line-icons.min.css',
    'resources/plantilla/css/ionicons.min.css',
    'resources/plantilla/css/adminlte.css',
    'resources/plantilla/css/select2.min.css'
], 'sisgea/css/plantilla.css')
.scripts([
    'resources/plantilla/js/jquery.min.js',
    'resources/plantilla/js/jquery-ui.min.js',
    'resources/plantilla/js/bootstrap.bundle.min.js',
    'resources/plantilla/js/adminlte.js',
    'resources/plantilla/js/sweetalert2.all.min.js',
    'resources/plantilla/js/select2.min.js'
], 'sisgea/js/plantilla.js')
.js(['resources/js/app.js'],'sisgea/js/app.js').vue({ version: 2 });