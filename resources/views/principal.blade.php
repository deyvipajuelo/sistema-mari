<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Sistema de gestion de expedientes Administrativos-SISGEA">
    <meta name="author" content="jhtnblas61@gmail.com">
    <meta name="keyword" content="Archivo Central">
    <link rel="shortcut icon" href="img/LogoPj.png">
    <title>CSJA-ARCHIVO CENTRAL</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="user" content="{{ Auth::user() }}">
    <!-- Icons -->
    <link href="css/plantilla.css" rel="stylesheet">
    <style>
        .mc-section-title {
            background: #AF2418;
            color: #fff;
            padding: 5px;
            border-radius: 5px;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini">
    
    <div class="wrapper" id="app">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Notifications Dropdown Menu -->
                
                <li class="nav-item">
                    <a class="nav-link text-danger" data-slide="true" href="{{ route('logout') }}" 
                    onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">Salir&nbsp;<i class="fa fa-sign-out"></i></a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
            </li>
               
            </ul>
        </nav>
        <!-- /.navbar -->
        <!-- Main Sidebar Container -->
        @if(Auth::check())
            @if(Auth::user()->idrol==1)
                @include('plantilla/sidebaradministradorsistema')
            @elseif (Auth::user()->idrol==2)
                @include('plantilla/sidebarusuariosistema')
            @elseif (Auth::user()->idrol==3)
                @include('plantilla/sidebarODECMA')
            @elseif (Auth::user()->idrol==4)
                @include('plantilla/sidebarCordinador')
            @else
            @endif

        @endif
       

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
          
            <!-- /.content-header -->

            <!-- Main content -->
            @yield('contenido')
        <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <strong>Copyright &copy; 2021 <a href="https://www.pj.gob.pe/wps/wcm/connect/cortesuperiorancashpj/s_csj_ancash_nuevo/as_inicio/inicio_corte_ancash" target="_blank">Corte Superior de Justicia de Ancash</a>.</strong>
            Archivo Central.
            <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> 1.1.0
            </div>
        </footer>
    </div>
   

    
    <!-- Bootstrap and necessary plugins -->
    <script src="js/app.js"></script>
    <script src="js/plantilla.js"></script>
</body>

</html>