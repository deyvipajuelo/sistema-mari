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
                <a href="#"  class="d-block">{{Auth::user()->usuario}}</a>
                <a href="#">
                    <i class="fa fa-circle text-success" ></i>&nbsp;Online
                </a>
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
                        <i class="nav-icon fa fa-wrench"></i>
                        <p>
                            Mantenimiento
                            <i class="right fa fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li @click="menu=1" class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fa fa-gear nav-icon"></i>
                                <p>Sede</p>
                            </a>
                        </li>
                        <li @click="menu=2" class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fa fa-gear nav-icon"></i>
                                <p>Perfil</p>
                            </a>
                        </li>
                        <li @click="menu=3" class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fa fa-gear nav-icon"></i>
                                <p>Tipo Personal</p>
                            </a>
                        </li>
                        <li @click="menu=4" class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fa fa-gear nav-icon"></i>
                                <p>Personal</p>
                            </a>
                        </li>
                        <li @click="menu=5" class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fa fa-gear nav-icon"></i>
                                <p>Area</p>
                            </a>
                        </li>
                        <li @click="menu=6" class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fa fa-gear nav-icon"></i>
                                <p>Instancia</p>
                            </a>
                        </li>
                        <li @click="menu=7" class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fa fa-group nav-icon"></i>
                                <p>Persona</p>
                            </a>
                        </li>
                        <li class="nav-header">Expediente</li>
                        <li @click="menu=14" class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fa fa-gear nav-icon"></i>
                                <p>Especialidad</p>
                            </a>
                        </li>
                        <li @click="menu=11" class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fa fa-gear nav-icon"></i>
                                <p>Tipo Expediente</p>
                            </a>
                        </li>
                        <li @click="menu=10" class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fa fa-gear nav-icon"></i>
                                <p>Estado</p>
                            </a>
                        </li>
                        <li @click="menu=12" class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fa fa-gear nav-icon"></i>
                                <p>Tipo Archivo</p>
                            </a>
                        </li>
                        <li @click="menu=13" class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fa fa-gear nav-icon"></i>
                                <p>Tipo Conclusion</p>
                            </a>
                        </li>
                        <li @click="menu=24" class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fa fa-gear nav-icon"></i>
                                <p>Clase persona</p>
                            </a>
                        </li>
                        <li @click="menu=25" class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fa fa-gear nav-icon"></i>
                                <p>Parte Procesal</p>
                            </a>
                        </li>
                        <li @click="menu=26" class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fa fa-gear nav-icon"></i>
                                <p>Materia/Delito</p>
                            </a>
                        </li>
                        <li class="nav-header">Paquete</li>
                        <li @click="menu=15" class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fa fa-gear nav-icon"></i>
                                <p>Distrito Judicial</p>
                            </a>
                        </li>
                        <li @click="menu=16" class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fa fa-gear nav-icon"></i>
                                <p>Provincia</p>
                            </a>
                        </li>
                        <li @click="menu=17" class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fa fa-gear nav-icon"></i>
                                <p>Ubicación Instancia</p>
                            </a>
                        </li>
                        <li @click="menu=18" class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fa fa-gear nav-icon"></i>
                                <p>Organo Judicial</p>
                            </a>
                        </li>
                        <li @click="menu=19" class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fa fa-gear nav-icon"></i>
                                <p>Instancia Judicial</p>
                            </a>
                        </li>
                        <li @click="menu=20" class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fa fa-gear nav-icon"></i>
                                <p>Local</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-desktop"></i>
                        <p>Ingreso
                            <i class="fa fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li @click="menu=21" class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fa fa-file-text nav-icon"></i>
                                <p>Ingreso</p>
                            </a>
                        </li>
                        <li @click="menu=23" class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fa fa-barcode nav-icon"></i>
                                <p>Expediente</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-check"></i>
                        <p>Verificación
                            <i class="fa fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li @click="menu=27" class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fa fa-archive nav-icon"></i>
                                <p>Verificar expediente</p>
                            </a>
                        </li>
                        
                       
                    </ul>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-search"></i>
                        <p>Búsqueda
                            <i class="fa fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li @click="menu=28" class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fa fa-search nav-icon"></i>
                                <p>Buscar expediente</p>
                            </a>
                        </li>
                        
                       
                    </ul>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-archive"></i>
                        <p>Desarchivar
                            <i class="fa fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li @click="menu=32" class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fa fa-archive nav-icon"></i>
                                <p>Desarchivar</p>
                            </a>
                        </li>
                        <li @click="menu=33" class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fa fa-barcode nav-icon"></i>
                                <p>Historico Desarchivado</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-file"></i>
                        <p>Reportes
                            <i class="fa fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li @click="menu=31" class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fa fa-file nav-icon"></i>
                                <p>Ingresos</p>
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
                        <li @click="menu=8" class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fa fa-cog nav-icon"></i>
                                <p>Roles</p>
                            </a>
                        </li>
                        <li @click="menu=9" class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fa fa-users nav-icon"></i>
                                <p>Usuarios</p>
                            </a>
                        </li>
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
