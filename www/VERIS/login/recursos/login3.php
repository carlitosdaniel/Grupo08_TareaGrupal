<?php
ob_start();

session_start();
include("constantes.php");
$conn = conectarBD();
?>

<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>ClinicaMedica</title>
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
            <div class="header-top_area">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-6 col-md-6">
                            <div class="short_contact_list">
                                <ul>
                                    <li><a href="#"> <i class="fa fa-envelope"></i> iajacome2@espe.edu.ec</a></li>
                                    <li><a href="#"> <i class="fa fa-phone"></i> 14376</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="sticky-header" class="main-header-area">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-xl-3 col-lg-2">
                            <div class="logo">
                                <a href="#">
                                    <img src="../../img/logo.png" alt="">
                                </a>
                            </div>
                        </div>
                        <!-- <div class="col-xl-3 col-lg-3 d-none d-lg-block">
                            <div class="Appointment">
                                <div class="book_btn d-none d-lg-block">
                                    <a href="login.php">Iniciar Sesion</a>
                                </div>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- header-end -->

    <!-- slider_area_start -->
    <div class="slider_area">
        <div class="slider_active owl-carousel">
            <div class="single_slider  d-flex align-items-center slider_bg_2">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="slider_text ">
                                <h3> <span>CLINICA</span> <br>
                                    MEDICA </h3>
                                <!-- form itself start -->
                                <div class="container text-center">
                                    <form action="" method="POST" class="mt-3">
                                        <h2 class="mb-4">Formulario de login</h2>

                                        <div class="form-group">
                                            <select name="Nombre" class="form-control">
                                                <option disabled selected>Escoje un usuario: </option>
                                                <?php
                                                require_once("usuarios.php");
                                                $usuarios = array();

                                                // Modificar la consulta para seleccionar solo los usuarios con rol 2
                                                $sql = "SELECT IdUsuario, Nombre, Password, Rol FROM usuarios WHERE Rol = 3";

                                                $result = $conn->query($sql);

                                                if ($result->num_rows > 0) {
                                                    while ($row = $result->fetch_assoc()) {
                                                        $usuario = new Usuarios($row["IdUsuario"], $row["Rol"], $row["Nombre"], $row["Password"], $row["Foto"]);
                                                        $usuarios[] = $usuario;
                                                    }

                                                    foreach ($usuarios as $usuario) {
                                                        echo "<option value='{$usuario->getNombre()}'>{$usuario->getNombre()}</option>";
                                                    }
                                                } else {
                                                    echo "No se encontraron resultados.";
                                                }

                                                $conn->close();
                                                ?>
                                            </select>
                                        </div>

                                        <div class="input-box">
                                            <input type="password" placeholder="Password" name="Password"
                                                class="form-control">
                                            <i class="bx bxs-lock-alt"></i>
                                        </div>

                                        <br>

                                        <div class="form-group">
                                            <input type="submit" class="btn btn-success" value="LOGIN">
                                            <a href="../../index.html" class="btn btn-danger">Cancelar...</a>
                                        </div>
                                    </form>
                                    <?php
                                    require_once("validaciones.php");
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>








    <!-- footer start -->
    <footer class="footer">
        <div class="footer_top">
            <div class="container">
                <div class="row">
                    <div class="col-xl-4 col-md-6 col-lg-4">
                        <div class="footer_widget">
                            <div class="footer_logo">
                                <a href="#">
                                    <img src="../../img/footer_logo.png" alt="">
                                </a>
                            </div>
                            <p>
                                Clinica Medica
                            </p>
                            <div class="socail_links">
                                <ul>
                                    <li>
                                        <a href="#">
                                            <i class="ti-facebook"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="ti-twitter-alt"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-instagram"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>

                        </div>
                    </div>
                    <div class="col-xl-2 offset-xl-1 col-md-6 col-lg-3">
                        <div class="footer_widget">
                            <h3 class="footer_title">
                                Departments
                            </h3>
                            <ul>
                                <li><a href="#">Consultas</a></li>
                                <li><a href="#">Medicos</a></li>
                                <li><a href="#">Pacientes</a></li>
                                <li><a href="#">Recetas</a></li>
                            </ul>

                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 col-lg-3">
                        <div class="footer_widget">
                            <h3 class="footer_title">
                                Address
                            </h3>
                            <p>
                                Universidad de las Fuerzas Armadas ESPE <br>
                                +10 367 467 8934 <br>
                                iajacome2@espe.edu.ec
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="copy-right_text">
            <div class="container">
                <div class="footer_border"></div>
                <div class="row">
                    <div class="col-xl-12">
                        <p class="copy_right text-center">
                            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                            Copyright &copy;
                            <script>document.write(new Date().getFullYear());</script> All rights reserved | This
                            template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by Ivonne Jacome
                            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- footer end  -->
    <!-- link that opens popup -->

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
    <script src="js/contact.js"></script>
    <script src="js/jquery.ajaxchimp.min.js"></script>
    <script src="js/jquery.form.js"></script>
    <script src="js/jquery.validate.min.js"></script>
    <script src="js/mail-script.js"></script>

    <script src="../../js/main.js"></script>
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