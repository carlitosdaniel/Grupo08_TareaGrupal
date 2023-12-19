<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Docmed</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- <link rel="manifest" href="site.webmanifest"> -->
    <link rel="shortcut icon" type="image/x-icon" href="../../img/favicon.png">
    <!-- Place favicon.ico in the root directory -->

    <!-- CSS here -->
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/owl.carousel.min.css">
    <link rel="stylesheet" href="../../css/magnific-popup.css">
    <link rel="stylesheet" href="../../css/font-awesome.min.css">
    <link rel="stylesheet" href="../../css/themify-icons.css">
    <link rel="stylesheet" href="../../css/nice-select.css">
    <link rel="stylesheet" href="../../css/flaticon.css">
    <link rel="stylesheet" href="../../css/gijgo.css">
    <link rel="stylesheet" href="../../css/animate.css">
    <link rel="stylesheet" href="../../css/slicknav.css">
    <link rel="stylesheet" href="../../css/style.css">
    <!-- <link rel="stylesheet" href="css/responsive.css"> -->
</head>

<body>
    <!--[if lte IE 9]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
        <![endif]-->

    <!-- header-start -->
    <header>
        <div class="header-area ">
            <div id="sticky-header" class="main-header-area">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-xl-3 col-lg-2">
                            <div class="logo">
                                <a href="../../index.html">
                                    <img src="../../img/logo.png" alt="">
                                </a>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-7">
                            <div class="main-menu  d-none d-lg-block">
                                <nav>
                                    <ul id="navigation">
                                        <!-- <li><a class="active" href="../../index.html">home</a></li> -->
                                        <li><a href="../consultas/consultas.php">Consultas</a></li>
                                        <!-- <li><a href="../medico/medico.php">Medicos</a></li>
                                        <li><a href="../pacientes/paciente.php">Pacientes</a></li>
                                        <li><a href="../usuarios/usuarios.php">Usuarios</a></li>
                                        <li><a href="../roles/roles.php">Roles</a></li> -->
                                        <li><a href="../recetas/receta.php">Recetas</a></li>
                                        <!-- <li><a href="../medicamentos/medicamentos.php">Medicamento</a></li>
                                        <li><a href="../especialidades/especialidades.php">especialidades</a></li> -->
                                    </ul>
                                </nav>
                                <nav class="header__menu">
                                    <div class="header__nav__widget">
                                        <?php
                                        if (isset($_SESSION['Nombre'])) {
                                            $userName = $_SESSION['Nombre'];
                                            echo '<li class="nav-item"><a href="#" class="nav-link">Hola ' . $userName . '</a></li>';
                                            //echo '<button>Hola, ' . $userName . '</button>';
                                        }
                                        ?>
                                    </div>
                                </nav>
                                <nav class="header__menu">
                                    <div class="header__nav__widget ml-auto">
                                        <?php if (isset($_SESSION['Nombre'])): ?>
                                            <a href="../../login/recursos/cerrar.php" class="btn btn-light text-black"
                                                style="border: 1px solid white; border-radius: 10px;">
                                                Cerrar Sesión
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- header-end -->
    <!-- bradcam_area_start  -->
    <div class="bradcam_area breadcam_bg_2 bradcam_overlay">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="bradcam_text">
                        <h3>Clinica Medica</h3>
                        <p><a href="../../index.html">Home /</a> Listas</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- bradcam_area_end  -->

    <!-- JS here -->
    <script src="../../js/vendor/modernizr-3.5.0.min.js"></script>
    <script src="../../js/vendor/jquery-1.12.4.min.js"></script>
    <script src="../../js/popper.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>
    <script src="../../js/owl.carousel.min.js"></script>
    <script src="../../js/isotope.pkgd.min.js"></script>
    <script src="../../js/ajax-form.js"></script>
    <script src="../../js/waypoints.min.js"></script>
    <script src="../../js/jquery.counterup.min.js"></script>
    <script src="../../js/imagesloaded.pkgd.min.js"></script>
    <script src="../../js/scrollIt.js"></script>
    <script src="../../js/jquery.scrollUp.min.js"></script>
    <script src="../../js/wow.min.js"></script>
    <script src="../../js/nice-select.min.js"></script>
    <script src="../../js/jquery.slicknav.min.js"></script>
    <script src="../../js/jquery.magnific-popup.min.js"></script>
    <script src="../../js/plugins.js"></script>
    <script src="../../js/gijgo.min.js"></script>
    <!--contact js-->
    <script src="../js/contact.js"></script>
    <script src="../js/jquery.ajaxchimp.min.js"></script>
    <script src="../js/jquery.form.js"></script>
    <script src="../js/jquery.validate.min.js"></script>
    <script src="../js/mail-script.js"></script>

    <script src="../js/main.js"></script>
    <script>
        $('#datepicker').datepicker({
            iconsLibrary: 'fontawesome',
            icons: {
                rightIcon: '<span class="fa fa-caret-down"></span>'
            }
        });
        $('#datepicker2').datepicker({
            iconsLibrary: 'fontawesome',
            icons: {
                rightIcon: '<span class="fa fa-caret-down"></span>'
            }

        });
        $(document).ready(function () {
            $('.js-example-basic-multiple').select2();
        });
    </script>
</body>

</html>