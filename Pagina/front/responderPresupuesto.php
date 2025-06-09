<?php
    session_start();

    $user = "root";
    $pass = "";
    $host = "localhost";
    $dbname = "turboengine";

    $conexion = mysqli_connect($host, $user, $pass, $dbname);

    // Verificar si la conexión es exitosa antes de cerrarla
    if ($conexion) {
        mysqli_close($conexion);
    }

    if (!isset($_SESSION['id_usuario']) || $_SESSION['id_rol'] != 1) {
        header("Location: ../front/login.html?error=No tienes permiso para acceder");
        exit();
    }
    // Crear variables de sesión
    $idUsuario= $_SESSION["id_usuario"];
    $idrol = $_SESSION['id_rol'];
    $nombreUsuario = $_SESSION['nombre_usuario'];
    $dni = $_SESSION['dni'];
    $contraseña = $_SESSION['contraseña'];
    $correo = $_SESSION['correo'];  
    $telefono = $_SESSION['telefono'];
    $nombre = $_SESSION['nombre'];
    $apellidos = $_SESSION['apellidos'];
    $_SESSION['id_presupuesto'] = $_POST['id_presupuesto'];
    $id_presupuesto = $_SESSION['id_presupuesto'];
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="Mikel Ruiz" />
        <title>Taller TurboEngine</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="../assets/Logo1.jpeg" />
        <!-- Font Awesome icons (free version)-->
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700" rel="stylesheet" type="text/css" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="../css/styles.css" rel="stylesheet" />
        <!-- Mi archivo CSS -->
        <link href="../css/miStyle.css" rel="stylesheet" />
    </head>
    <body id="page-top">
        <!-- Navigation-->
          <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
            <div class="container">
                <a class="navbar-brand" href="#page-top"><img src="../assets/img/misImagenes/titulo-Photoroom.png" alt="..." /></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    Menu
                    <i class="fas fa-bars ms-1"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav text-uppercase ms-auto py-4 py-lg-0">
                        <li class="nav-item"><a class="nav-link" href="../front/gestionPresupuestos.php">Volver</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Masthead-->
        <header class="masthead">
            <div class="container">
                <div class="masthead-subheading">¡Conectado: <?php echo $nombre ?>!</div>
                <div class="masthead-heading text-uppercase">Responder Presupuesto</div>
                <a class="btn btn-primary btn-xl text-uppercase" href="#formulario">Responder</a>
            </div>
        </header>
        <!-- Formulario de Registro -->
        <section class="page-section" id="formulario">
            <div class="container">
                <div class="text-center">
                    <h2 class="section-heading text-uppercase">Responder al presupuesto del cliente</h2>
                    <h3 class="section-subheading text-muted">Facilite una respuesta al cliente en base a su consulta de presupuesto.</h3>
                </div>
                <form id="registroForm" action="../back/responder_presupuesto.php" method="POST">
                    <div class="row align-items-stretch mb-5">
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <!-- Label y textarea Resumen -->
                                <label for="id_presupuesto" class="form-label">ID Presupuesto</label>
                                <input class="form-control" id="id_presupuesto" name="id_presupuesto" rows="6" value="<?php echo $id_presupuesto; ?>" style="width : 15%"/>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <!-- Label y textarea Resumen -->
                                <label for="respuesta" class="form-label">Respuesta</label>
                                <textarea class="form-control" id="respuesta" name="respuesta" placeholder="Añade la respuesta del presupuesto al cliente..." rows="8" required></textarea>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <!-- Label y textarea Resumen -->
                                <label for="precio" class="form-label">Precio del presupuesto sin IVA:</label>
                                <input class="form-control" id="precio" name="precio" rows="6" placeholder="No introduzca el simbolo '€'" style="width : 20%"/>
                            </div>
                        </div>
                    </div>
                    <!-- Botón de envío -->
                    <div class="text-center">
                        <button class="btn btn-primary btn-xl text-uppercase" type="submit">Actualizar datos</button>
                    </div>
                </form>
            </div>
        </section>

       
        <!-- Footer-->
        <footer class="footer py-4" id="footer">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-4 text-lg-start">Copyright &copy; TurboEngine 2025</div>
                    <div class="col-lg-4 my-3 my-lg-0">
                        <a class="btn btn-light btn-social mx-2" href="#!" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                        <a class="btn btn-light btn-social mx-2" href="#!" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-light btn-social mx-2" href="#!" aria-label="LinkedIn"><i class="fab fa-instagram"></i></a>
                    </div>
                    <div class="col-lg-4 text-lg-end">
                        <a class="link-light text-decoration-none me-3" href="#!">Polítca de privacidad</a>
                        <a class="link-light text-decoration-none" href="#!">Condiciones de uso</a>
                    </div>
                </div>
            </div>
        </footer>

        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="../js/scripts.js"></script>
        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
        <!-- * *                               SB Forms JS                               * *-->
        <!-- * * Activate your form at https://startbootstrap.com/solution/contact-forms * *-->
        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
        <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
    </body>
</html>
<?php
    session_abort();
?>