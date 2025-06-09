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

    if (!isset($_SESSION['id_usuario']) || $_SESSION['id_rol'] != 2) {
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
    // echo $_SESSION['id_rol'];
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
        <script src="../js/sweetAlert.js"></script>
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
                        <li class="nav-item"><a class="nav-link" href="./cliente.php">Página Principal</a></li>
                        <li class="nav-item"><a class="nav-link" href="./presupuestos.php">Presupuestos</a></li>
                        <li class="nav-item"><a class="nav-link" href="./citas.php">Citas</a></li>
                        <li class="nav-item"><a class="nav-link" href="./perfil.php">Volver a Perfil</a></li>
                        <li class="nav-item"><a class="nav-link" href="../back/logout.php">Salir</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Masthead-->
        <header class="masthead">
            <div class="container">
                <div class="masthead-heading text-uppercase">Gestiona tus Citas</div>
            </div>
        </header>

        <!-- Sección Gestión Usuarios -->
        <section id="gestionUsuarios" class="py-5">
            <div class="container">
            <h2 class="text-center text-uppercase mb-4">Citas de <?php echo $nombre ?></h2>
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-dark">
                        <tr class="text-center">
                            <th scope="col">Fecha de la cita</th>
                            <th scope="col">Hora de la cita</th>
                            <th scope="col">Fecha de solicitud</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php include '../back/obtener_citas_clientes.php'; ?>
                    </tbody>
                </table>
            </div>
            </div>
        </section>
        <br><br><br><br>        
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
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </body>
</html>
<?php
    session_abort();
?>