<?php
    // Iniciar sesión para acceder a las variables de sesión
    session_start();
    // Declarar variables de conexión a la base de datos
    $host = "localhost";
    $user = "root";
    $pass = "";
    $dbname = "turboengine";
    // Conectar a la base de datos
    $conexion = mysqli_connect($host, $user, $pass, $dbname);
    // Verificar si la conexión a la base de datos se realizó correctamente
    if (!$conexion) {
        die("Error de conexión: " . mysqli_connect_error());
    }

    // Obtener el ID del usuario actual
    $idUsuario = $_SESSION["id_usuario"];

    // Obtener datos del formulario, si se deja vacio optiene el valor de la sesión
    $nombre = !empty($_POST['nombre']) ? $_POST['nombre'] : $_SESSION['nombre'];
    $apellidos = !empty($_POST['apellidos']) ? $_POST['apellidos'] : $_SESSION['apellidos'];
    $correo = !empty($_POST['correo']) ? $_POST['correo'] : $_SESSION['correo'];
    $telefono = !empty($_POST['telefono']) ? $_POST['telefono'] : $_SESSION['telefono'];
    $dni = !empty($_POST['dni']) ? $_POST['dni'] : $_SESSION['dni'];
    $nombreUsuarioNuevo = !empty($_POST['nombreUsuario']) ? $_POST['nombreUsuario'] : $_SESSION['nombre_usuario'];
    $contraseña = !empty($_POST['contraseña']) ? $_POST['contraseña'] : $_SESSION['contraseña'];

    // Verificar si el nombre de usuario ya existe (excepto el actual usuario), mediante una consulta SQL a la base de datos
    $sql_check = "SELECT id_usuario FROM usuarios WHERE nombre_usuario = '$nombreUsuarioNuevo' AND id_usuario != '$idUsuario'";
    // Ejecutar la consulta
    $resultado = mysqli_query($conexion, $sql_check);
    // Verificar si existe un usuario con el mismo nombre de usuario
    if (mysqli_num_rows($resultado) > 0) {
        echo "El nombre de usuario ya está en uso. Elige otro.";
        exit();
    }

    // Si algún campo está vacío, no actualizarlo en la base de datos, de esta manera no se perderán los datos actuales
    $updates = [];
    if (!empty($_POST['nombre'])) $updates[] = "nombre = '" . $_POST['nombre'] . "'";
    if (!empty($_POST['apellidos'])) $updates[] = "apellidos = '" . $_POST['apellidos'] . "'";
    if (!empty($_POST['correo'])) $updates[] = "correo = '" . $_POST['correo'] . "'";
    if (!empty($_POST['telefono'])) $updates[] = "numero_telefono = '" . $_POST['telefono'] . "'";
    if (!empty($_POST['dni'])) $updates[] = "dni = '" . $_POST['dni'] . "'";
    if (!empty($_POST['nombreUsuario'])) $updates[] = "nombre_usuario = '" . $_POST['nombreUsuario'] . "'";
    if (!empty($_POST['contraseña'])) $updates[] = "contraseña = '" . $_POST['contraseña'] . "'";
    // Si hay actualizaciones, construir la consulta de actualización
    if (!empty($updates)) {
        // Consulta UPDATE para actualizar los datos del usuario
        // implode() une los elementos del array $updates en una cadena separada por comas
        $sql_update = "UPDATE usuarios SET " . implode(", ", $updates) . " WHERE id_usuario = '$idUsuario'";
        // Ejecutar la consulta de actualización
        mysqli_query($conexion, $sql_update);
    }
    // Actualizar datos del usuario mediante una consulta UPDATE a la base de datos, si los campos no se cambian en el formulario,
    // se mantendrán los valores actuales de la sesión
    $sql_update = "UPDATE usuarios 
                SET nombre = '$nombre', 
                    apellidos = '$apellidos', 
                    correo = '$correo', 
                    numero_telefono = '$telefono', 
                    dni = '$dni', 
                    nombre_usuario = '$nombreUsuarioNuevo',
                    contraseña = '$contraseña'
                WHERE id_usuario = '$idUsuario'";
    // Si la consulta se ejecuta correctamente, actualizar las variables de sesión
    if (mysqli_query($conexion, $sql_update)) {
        $_SESSION['nombre'] = $nombre;
        $_SESSION['apellidos'] = $apellidos;
        $_SESSION['correo'] = $correo;
        $_SESSION['telefono'] = $telefono;
        $_SESSION['dni'] = $dni;
        $_SESSION['nombre_usuario'] = $nombreUsuarioNuevo;
        // Refresca la página en la que se encuentra el usuario para mostrar los cambios, junto a un mensaje de éxito
        header("Location: ../front/perfil.php?success=Perfil actualizado correctamente");
        exit();
    } else {
        // Si hay un error al ejecutar la consulta, mostrar un mensaje de error
        echo "Error al actualizar el perfil: " . mysqli_error($conexion);
    }

    // Cerrar conexión
    mysqli_close($conexion);
?>
