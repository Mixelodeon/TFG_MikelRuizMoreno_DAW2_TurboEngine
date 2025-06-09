<?php
    // Iniciar sesión para acceder a las variables de sesión
    session_start();
    // Verificar si el usuario ha iniciado sesión, si no, redirigir al login con mensaje de error
    if(!isset($_SESSION["id_usuario"]) && $_SESSION["nombreUsuario"] && $_SESSION["contraseña"]){
        header("Location: ../front/login.html?error=Acceso no autorizado");
        exit();
    }
    // Declarar las variables de sesión con los datos del usuario
    $idUsuario = $_SESSION['id_usuario'];
    $nombreUsuario = $_SESSION['nombre_usuario'];
    $contraseña = $_SESSION['contraseña'];
    $idrol = $_SESSION['id_rol'];
    $nombre = $_SESSION['nombre'];
    $apellidos = $_SESSION['apellidos'];
    $correo = $_SESSION['correo'];
    $telefono = $_SESSION['telefono'];
    $dni = $_SESSION['dni'];
    // Conectar a la base de datos
    $conexion = mysqli_connect("localhost", "root", "", "turboengine");
    // Verificar si la conexión a la base de datos se realizó correctamente
    if (!$conexion) {
        die("Error en la conexión: " . mysqli_connect_error());
    }
    // Recibir datos del formulario de presupuestos
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $año = $_POST['anio'];
    // strtoupper() convierte la matrícula a mayúsculas y trim() elimina espacios en blanco al inicio y al final
    $matricula = strtoupper(trim($_POST['matricula']));
    $servicio = $_POST['servicio'];
    $descripcion = $_POST['descripcion'];
    // Consulta SELECT para obtener el vehiculo por la matrícula indicada en el formulario de presupuestos
    $queryVehiculo = "SELECT * FROM vehiculos WHERE matricula = ?";
    // Preparar la consulta para evitar inyecciones SQL
    $stmtVehiculo = mysqli_prepare($conexion, $queryVehiculo);
    // Vincular el parámetro de la consulta
    mysqli_stmt_bind_param($stmtVehiculo, "s", $matricula);
    // Ejecutar la consulta
    mysqli_stmt_execute($stmtVehiculo);
    // Obtener el resultado de la consulta
    $resultadoVehiculo = mysqli_stmt_get_result($stmtVehiculo);
    // Verificar si el vehículo ya existe en la base de datos
    // Si no existe, se inserta un nuevo vehículo con los datos proporcionados en el formulario
    if(mysqli_num_rows($resultadoVehiculo) === 0) {
        // Convertir año (numero) a format de fecha
        $anio_formateado = $anio . "-01-01";
        // Consulta INSERT para agregar un nuevo vehículo a la base de datos
        $insertVehiculo = "INSERT INTO vehiculos (matricula, marca, modelo, año) VALUES (?, ?, ?, ?)";
        // Preparar la consulta para evitar inyecciones SQL
        $stmtInsertVehiculo = mysqli_prepare($conexion, $insertVehiculo);
        // Vincular los parámetros de la consulta
        mysqli_stmt_bind_param($stmtInsertVehiculo, "ssss", $matricula, $marca, $modelo, $año);
        // Ejecutar la consulta para insertar el nuevo vehículo
        mysqli_stmt_execute($stmtInsertVehiculo);
    }
    // Consulta INSERT para agregar un nuevo presupuesto a la base de datos
    // Se utiliza el ID del usuario actual, la matrícula del vehículo, la descripción y el servicio solicitado
    $insertPresupuesto = "INSERT INTO presupuestos (id_usuario, matricula, descripcion, servicio) VALUES (?, ?, ?, ?)";
    // Preparar la consulta para evitar inyecciones SQL
    $stmtPresupuesto = mysqli_prepare($conexion, $insertPresupuesto);
    // Vincular los parámetros de la consulta
    mysqli_stmt_bind_param($stmtPresupuesto, "isss", $idUsuario, $matricula, $descripcion, $servicio);
    // Ejecutar la consulta para insertar el nuevo presupuesto
    mysqli_stmt_execute($stmtPresupuesto);
    mysqli_close($conexion);
    header("Location: ../front/presupuestos.php?success=Presupuesto solicitado correctamente");
    exit();
?>
