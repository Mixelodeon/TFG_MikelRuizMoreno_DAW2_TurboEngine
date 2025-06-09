<?php
    // Iniciar sesión para acceder a las variables de sesión
    session_start();

    // Verificar permisos del usuario conectado, si no es administrador, redirigir a login
    if (!isset($_SESSION['id_usuario']) || $_SESSION['id_rol'] != 1) {
        header("Location: ../front/login.html?error=No tienes permiso para acceder");
        exit();
    }
    // Obtener el ID del usuario a eliminar desde el formulario, en este caso el boton de eliminar
    $id_usuario = $_POST['id_usuario'];

    // Conexión a la base de datos
    $conexion = mysqli_connect("localhost", "root", "", "turboengine");
    // Verificar que la conexión se realizó correctamente
    if (!$conexion) {
        die("Error en la conexión: " . mysqli_connect_error());
    }
    // Consulta DELETE para eliminar el usuario de la base de datos
    $query = "DELETE FROM usuarios WHERE id_usuario = ?";
    // Preparar y ejecutar la consulta
    $stmt = mysqli_prepare($conexion, $query);
    // Verificar si la preparación de la consulta fue exitosa
    mysqli_stmt_bind_param($stmt, "i", $id_usuario);
    // Verificar si la vinculación de parámetros fue exitosa
    if (mysqli_stmt_execute($stmt)) {
        // Redirigir tras éxito
        header("Location: ../front/gestionUsuarios.php?success=UsuarioEliminado");
    } else {
        // Redirigir con error
        header("Location: ../front/gestionUsuarios.php?error=ErrorUsuarioEliminar");
    }

    // Cerrar la declaración y la conexión
    mysqli_stmt_close($stmt);
    mysqli_close($conexion);
?>
