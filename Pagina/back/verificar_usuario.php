<?php
    // Declarar las variables de sesión con los datos del usuario
    $host = "localhost";
    $user = "root";
    $pass = "";
    $dbname = "turboengine";
    // Establecer conexión a la base de datos
    $conexion = mysqli_connect($host, $user, $pass, $dbname);
    // Obtener el nombre de usuario desde la solicitud GET
    $nombreUsuario = $_GET["nombreUsuario"];

    // Consulta SELECT para contar el número de usuarios con el nombre de usuario proporcionado
    $stmt = $conexion->prepare("SELECT COUNT(*) as cantidad FROM usuarios WHERE nombre_usuario = ?");
    // Parametrizar la consulta para evitar inyecciones SQL
    $stmt->bind_param("s", $nombreUsuario);
    // Ejecutar la consulta y obtener el resultado
    $stmt->execute();
    // Obtener el resultado de la consulta
    $resultado = $stmt->get_result();
    // Verificar si se obtuvo algún resultado
    $fila = $resultado->fetch_assoc();

    echo json_encode(["existe" => $fila["cantidad"] > 0]);

    $stmt->close();
    $conexion->close();
?>
