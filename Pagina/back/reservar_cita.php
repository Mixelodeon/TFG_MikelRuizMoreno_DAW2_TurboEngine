<?php
    // Iniciar sesión para acceder a las variables de sesión
    session_start();
    // Establecer el tipo de contenido a JSON
    header('Content-Type: application/json');
    // Declarar las variables de sesión con los datos del usuario
    $host = "localhost";
    $user = "root";
    $pass = "";
    $dbname = "turboengine";
    // Establecer conexión a la base de datos
    $conexion = mysqli_connect($host, $user, $pass, $dbname);
    // Verificar si la conexión a la base de datos se realizó correctamente
    if (!$conexion) {
        echo json_encode(["error" => "Error de conexión"]);
        exit;
    }

    // Obtener datos del cliente mediante la sesión
    $id_usuario = $_SESSION['id_usuario'];
    $dni = $_SESSION['dni'];
    // Obtener datos de la cita desde el formulario
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    // Verificar si los datos necesarios están presentes
    if (!$id_usuario || !$fecha || !$hora) {
        header("Location: ../front/citas.php?error=DatosIncompletos");
        exit;
    }

    // Preparar la consulta SELECT para verificar si la cita está disponible
    $sqlCheck = mysqli_prepare($conexion, "SELECT * FROM citas WHERE fecha_cita = ? AND hora_cita = ? AND disponible = 1 AND id_usuario IS NULL");
    // Vincular los parámetros de la consulta
    mysqli_stmt_bind_param($sqlCheck, "ss", $fecha, $hora);
    // Ejecutar la consulta y obtener el resultado
    mysqli_stmt_execute($sqlCheck);
    // Obtener el resultado de la consulta
    $result = mysqli_stmt_get_result($sqlCheck);
    // Verificar si la cita está disponible
    if (mysqli_num_rows($result) === 0) {
        echo json_encode(["error" => "La cita ya no está disponible"]);
        exit;
    }

    // Preparar la consulta UPDATE para reservar la cita y asignarla al usuario
    $update = mysqli_prepare($conexion, "UPDATE citas SET disponible = 0, fecha_solicitud = NOW(), id_usuario = ? WHERE fecha_cita = ? AND hora_cita = ?");
    // Vincular los parámetros de la consulta
    mysqli_stmt_bind_param($update, "iss", $id_usuario, $fecha, $hora);
    // Ejecutar la consulta para reservar la cita
    $success = mysqli_stmt_execute($update);
    // Verificar si la consulta se ejecutó correctamente
    if ($success) {
        // Redirigir a la página de citas con mensaje de éxito
        header("Location: ../front/citas.php?success=CitaReservada");
        exit;
    } else {
        // Si hubo un error al reservar la cita, redirigir con mensaje de error
        header("Location: ../front/citas.php?error=ErrorReservarCita");
        exit;
    }
?>