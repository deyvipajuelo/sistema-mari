<!DOCTYPE html>
<html lang="es">
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <meta name="description" content="Sistema de Administracion de Archivos">
  <meta name="author" content="JBLASR">
  <meta name="keyword" content="Sistema de Administracion de Archivos">

  <title>CSJA-ARCHIVO CENTRAL</title>

  <!-- Icons -->
  <link href="css/plantilla.css" rel="stylesheet">
  <!-- Vendor CSS Files -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="css/style.css" rel="stylesheet">
  <!-- ESTILOS PARA PAGINA PRINCIPAL -->
  <link href="css/home.css" rel="stylesheet">
</head>

<body id="hero">
  <header id="header" class="fixed-top d-flex align-items-center">
    <div class="container d-flex align-items-center">

      <div class="logo me-auto">
        <h1><a href="#">SISGEA</a></h1>
        <!-- Uncomment below if you prefer to use an image logo -->
        <!-- <a href="index.html"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->
      </div>

      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link scrollto active" href="#hero">Inicio</a></li>
          
          <li class="dropdown"><a href="#"><span>Servicios</span> <i class="bi bi-chevron-down"></i></a>
            <ul>
              <li><a href="#">Consultas</a></li>
              
            </ul>
          </li>
          <li class="dropdown"><a href="#"><span>Otros</span> <i class="bi bi-chevron-down"></i></a>
            <ul>
              <li><a href="https://www.pj.gob.pe/wps/wcm/connect/CorteSuperiorAncashPJ/s_csj_Ancash_nuevo/as_servicios/as_servicios_ciudadano/as_dir_sedes/" target="_blank">Directorio telefónico</a></li>
              <li><a href="https://cej.pj.gob.pe/cej/forms/busquedaform.html" target="_blank">Expedientes judiciales</a></li>
              
            </ul>
          </li>
          <li><a class="nav-link scrollto" href="#myModal" class="trigger-btn" data-toggle="modal">Login</a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header>
  
  <main id="main">
      <!-- ======= Portfolio Details Section ======= -->
      <section id="portfolio-details" class="portfolio-details">
        <div class="container">

          <div class="row gy-4">

            <div class="col-lg-8">
              <div class="portfolio-details-slider swiper">
                <div class="swiper-wrapper align-items-center">

                  <div class="swiper-slide">
                    <img src="img/portfolio/portfolio-1.jpg" alt="">
                  </div>

                  <div class="swiper-slide">
                    <img src="img/portfolio/portfolio-2.jpg" alt="">
                  </div>

                  <div class="swiper-slide">
                    <img src="img/portfolio/portfolio-3.jpg" alt="">
                  </div>

                </div>
                <div class="swiper-pagination"></div>
              </div>
            </div>

            <div class="col-lg-4">
              <div class="portfolio-info">
                <h3>Sistema de Gestión de Expedientes Administrativos</h3>
                <ul>
                  <li><strong>Instancia</strong>: Archivo Central</li>
                  <li><strong>Area</strong>: Unidad de servicios Judiciales / ODECMA</li>
                  <li><strong>Sede Judicial</strong>: Corte Superior de Justicia de Ancash</li>
                  
                </ul>
              </div>
              
            </div>

          </div>

        </div>
      </section><!-- End Portfolio Details Section -->

  </main>
  
  <!-- ======= Footer ======= -->
  <footer id="footer">
    <div class="container">
      <div class="copyright">
        &copy; Copyright <strong><span>Archivo Central-CSJAncash</span></strong>. All Rights Reserved
      </div>
      <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/free-one-page-bootstrap-template-amoeba/ -->
        Designed by <a href="#">Jhonatan Blas.R - jhtnblas61@gmail.com</a>
      </div>
    </div>
  </footer><!-- End #footer -->
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
  <!-- INICIO DE MODAL SESION-->
  <div id="myModal" class="modal fade">
    <div class="modal-dialog modal-login modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Archivo Central</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
              <p class="login-box-msg">Control de acceso al sistema</p>
                <form action="{{route('login')}}" method="POST">
                  {{ csrf_field() }}
                    
                  <div class="input-group mb-3 {{$errors->has('usuario' ? 'is-invalid' : '')}}">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="icon-user"></span>
                        </div>
                        </div>
                    <input type="text" value="{{old('usuario')}}" name="usuario" id="usuario" class="form-control" placeholder="Usuario">
                    {!!$errors->first('usuario','<span class="invalid-feedback">:message</span>')!!}
                  </div>
                  <div class="input-group mb-3 {{$errors->has('password' ? 'is-invalid' : '')}}">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="icon-lock"></span>
                        </div>
                        </div>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                    {!!$errors->first('password','<span class="invalid-feedback">:message</span>')!!}
                  </div>
                  <div class="row">
                    <div class="col-8">
                    <div class="icheck-primary">
                        <input type="checkbox" id="remember">
                        <label for="remember">
                        Remember Me
                        </label>
                    </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary">Acceder</button>
                    </div>
                    <!-- /.col -->
                  </div>
                </form>
            </div>
            <div class="modal-footer">Corte Superior de Justicia de Ancash</div>
        </div>
    </div>
  </div>

  <!-- Bootstrap and necessary plugins -->
    <script src="js/plantilla.js"></script>
    
    <script src="vendor/glightbox/js/glightbox.min.js"></script>
    <script src="vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="vendor/swiper/swiper-bundle.min.js"></script>
    <script src="vendor/php-email-form/validate.js"></script>
  
    <!-- Template Main JS File -->
    <script src="js/main.js"></script>

    
    <!-- Javascript -->          
    <script>
      $( document ).ready(function() {
        $('#myModal').modal('toggle')
      });
    </script>
</body>
</html>