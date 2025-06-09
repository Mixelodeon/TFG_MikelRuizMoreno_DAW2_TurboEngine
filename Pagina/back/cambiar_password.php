<?php
    // Variables con datos de conexión a la base de datos
    $user = "root";
    $pass = "";
    $host = "localhost";
    $dbname = "turboengine";
    // Conectar a la base de datos
    $conexion = mysqli_connect($host, $user, $pass, $dbname);
    // Obtenemos la nueva contraseña y el token con el id de usuario y el nombre de usuario
    $nuevaPassword = $_POST['nuevaPassword'];
    $token = $_POST['token'];
    // Validar que se hayan recibido los datos necesarios
    if(!$token || !$nuevaPassword) {
        header("Location: ../front/formularioPassword.php?error=Token o contraseña no proporcionados");
        exit();
    }
    // Consulta select a la base de datos para verificar el token
    $sqlToken = "SELECT id_usuario, expiracion_token FROM reset_tokens WHERE token = '$token'";
    $resultadoToken = mysqli_query($conexion, $sqlToken);
    // Verificar si el token es válido
    if (mysqli_num_rows($resultadoToken) == 1) {
    $datos = mysqli_fetch_assoc($resultadoToken);
    // Extraer el id de usuario y la fecha de expiración del token
    $idUsuario = $datos['id_usuario'];
    $expiracion = $datos['expiracion_token'];

    // Validar que el token no esté expirado
    if (strtotime($expiracion) < time()) {
        die("El token ha expirado.");
    }
    // Consulta para actualizar la contraseña del usuario
    $updateQuery = "UPDATE usuarios SET contraseña = '$nuevaPassword' WHERE id_usuario = '$idUsuario'";
    $actualizado = mysqli_query($conexion, $updateQuery);
    // Verificar si la contraseña se actualizó correctamente
    if ($actualizado && mysqli_affected_rows($conexion) > 0) {
        // Eliminar el token para que no se reutilice
        mysqli_query($conexion, "DELETE FROM reset_tokens WHERE token = '$token'");
        header("Location: ../front/login.html?success=contraseñaActualizada");
    } else {
        echo "Error al actualizar la contraseña.";
    }
    } else {
        echo "Token inválido.";
    }


?>