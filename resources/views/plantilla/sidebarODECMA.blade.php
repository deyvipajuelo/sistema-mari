<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <img src="img/LogoPj.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">SISGEA</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="img/user2.png" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" style="color: #63FF01;" class="d-block">{{Auth::user()->usuario}}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li @click="menu=0" class="nav-item">
                    <a class="nav-link" href="main"><i class="nav-icon fa fa-home"></i><p>Inicio</p></a>
                </li>
              
                <li class="nav-header">MENU</li>
                
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-desktop"></i>
                        <p>Ingreso
                            <i class="fa fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                       
                        <li @click="menu=33" class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fa fa-barcode nav-icon"></i>
                                <p>Expediente</p>
                            </a>
                        </li>
                       
                    </ul>
                </li>
               
                
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-globe"></i>
                        <p>Acceso
                            <i class="fa fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        
                        <li @click="menu=22" class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fa fa-key nav-icon"></i>
                                <p>Cambiar Clave</p>
                            </a>
                        </li>
                    </ul>
                </li>
                
                <li class="nav-header">Manuales</li>
                <li  class="nav-item">
                    <a href="http://localhost/archivocentral/sisgea/docs/MANUAL.pdf" class="nav-link" target="_blank">
                        <i class="nav-icon fa fa-file"></i>
                        <p>Manual de usuario</p>
                    </a>
                </li>
                
                <li class="nav-header">Opciones</li>
                <li @click="menu=29" class="nav-item">
                    <a href="#" class="nav-link">
                        <i  class="nav-icon fa fa-circle-o text-primary"></i>
                        <p class="text">Acerca de</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>