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
        <script src="../js/validaciones.js"></script>
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
                        <li class="nav-item"><a class="nav-link" href="../back/logout.php">Salir</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Masthead-->
        <header class="masthead">
            <div class="container">
                <div class="masthead-heading text-uppercase">Apartado de Perfil</div>
            </div>
        </header>
     
        <section id="perfil" class="py-5">
            <section id="gestion" class="py-5">
                <div class="container">
                    <h2 class="text-uppercase text-center mb-4">Gestión de Citas y Presupuestos</h2>
                    <div class="text-center">
                        <a href="./clienteVerCitas.php" class="btn btn-outline-secondary btn-lg m-2">Ver Mis Citas</a>
                        <a href="./clienteVerPresupuesto.php" class="btn btn-outline-secondary btn-lg m-2">Ver Mis Presupuestos</a>
                    </div>
                </div>
            </section>

            <div class="container">
                <h2 class="text-uppercase text-center mb-4">Gestiona tu Perfil</h2>
                    <form action="../back/procesar_perfil.php" method="POST">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" id="nombre" name="nombre" class="form-control" value="<?php echo $nombre ?>" />
                                <p id="errorNombre"></p>
                            </div>
                            <div class="col-md-6">
                                <label for="apellidos" class="form-label">Apellidos</label>
                                <input type="text" id="apellidos" name="apellidos" class="form-control" value="<?php echo $apellidos ?>" />
                                <p id="errorApellidos"></p>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="correo" class="form-label">Correo Electrónico</label>
                                <input type="email" id="correo" name="correo" class="form-control" value="<?php echo $correo ?>" />
                                <p id="errorCorreo"></p>
                            </div>
                            <div class="col-md-6">
                                <label for="telefono" class="form-label">Número de Teléfono</label>
                                <input type="tel" id="telefono" name="telefono" class="form-control" value="<?php echo $telefono ?>" />
                                <p id="errorTelefono"></p>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="dni" class="form-label">DNI</label>
                            <input type="text" id="dni" name="dni" class="form-control" value="<?php echo $dni ?>" />
                            <p id="errorDni"></p>
                        </div>
                        <div class="mb-3">
                            <label for="nombreUsuario" class="form-label">Usuario</label>
                            <input type="text" id="nombreUsuario" name="nombreUsuario" class="form-control" value="<?php echo $nombreUsuario ?>" />
                            <p id="errorNombreUsuario"></p>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" id="password" name="password" class="form-control" value="<?php echo $contraseña ?>" />
                            <p id="errorPassword"></p>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-xl">Actualizar Perfil</button>
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
        <!-- <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script> -->
    </body>
</html>

<?php 
    // Cerrar conexión
    session_abort()
?>