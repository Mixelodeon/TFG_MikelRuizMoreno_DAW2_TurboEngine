<?php 
    // Comprobar si la sesión está iniciada y si el usuario tiene el rol de administrador
    // Si no es así, redirigir al usuario a la página de inicio de sesión con un mensaje de error
    if(!isset($_SESSION['id_usuario']) || $_SESSION['id_rol'] != 1) {
        header("Location: ../front/login.html?error=No tienes permiso para acceder");
        exit();
    }
    // Conectar a la base de datos
    $conexion = mysqli_connect("localhost","root","","turboengine");
    // Verificar si la conexión a la base de datos se realizó correctamente
    if(!$conexion) {
        die("Error en la conexión: " . mysqli_connect_error());
    }
    // Consulta SELECT para obtener los usuarios con rol de cliente (id_rol = 2)
    $query = "SELECT * FROM usuarios WHERE id_rol = 2";
    // Ejecutar la consulta
    $resultado = mysqli_query($conexion, $query);
    // Verificar si la consulta se ejecutó correctamente
    if(!$resultado) {
        die("Error en la consulta: " . mysqli_error($conexion));
    }
    // Pintar la tabla con todos los usuarios con rol de cliente
    // Esta tabla se mostrará en la página de administración, con botones para eliminar usuarios
    while ($row = mysqli_fetch_assoc($resultado)) {
        echo "<tr class='text-center'>
                <td>{$row['id_usuario']}</td>
                <td>{$row['dni']}</td>
                <td>{$row['nombre']}</td>
                <td>{$row['apellidos']}</td>
                <td>{$row['correo']}</td>
                <td>{$row['numero_telefono']}</td>
                <td>{$row['nombre_usuario']}</td>
                <td>{$row['contraseña']}</td>
                <td>
                    <form method='POST' action='../back/eliminar_usuario.php' style='display:inline-block;'>
                        <input type='hidden' name='id_usuario' value='{$row['id_usuario']}' />
                        <button type='submit' class='btn btn-danger btn-sm'>Eliminar</button>
                    </form>
                </td>
            </tr>";
    }

    mysqli_close($conexion);
?>
