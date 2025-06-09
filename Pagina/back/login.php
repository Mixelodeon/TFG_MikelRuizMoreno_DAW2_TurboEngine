<?php
    // Iniciar sesión para acceder a las variables de sesión
    session_start(); 
    // Declaración de variables de conexión a la base de datos
    $user = "root";
    $pass = "";
    $host = "localhost";
    $dbname = "turboengine";
    // Conectar a la base de datos
    $conexion = mysqli_connect($host, $user, $pass, $dbname);
    // Verificar si la conexión a la base de datos se realizó correctamente
    if (!$conexion) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    // Obtener datos del formulario
    $nombreUsuario = $_POST['nombreUsuario'];
    $password = $_POST['password'];
    // Consulta SELECT para buscar el usuario en la base de datos
    $query = "SELECT * FROM usuarios WHERE nombre_usuario = '$nombreUsuario'";
    // Ejecutar la consulta
    $resultado = mysqli_query($conexion, $query);

    // Verificar si existe el usuario
    if(mysqli_num_rows($resultado) == 1) {
        // Obtener los datos del usuario
        $usuario = mysqli_fetch_assoc($resultado);

        // Comparar contraseña introducida con la almacenada en la base de datos
        if ($password === $usuario['contraseña']) {
            // Crear variables de sesión con datos del usuario
            $_SESSION['id_usuario'] = $usuario['id_usuario'];
            $_SESSION['nombre_usuario'] = $usuario['nombre_usuario'];
            $_SESSION['contraseña'] = $usuario['contraseña'];
            $_SESSION['id_rol'] = $usuario['id_rol'];
            $_SESSION['nombre'] = $usuario['nombre'];
            $_SESSION['apellidos'] = $usuario['apellidos'];
            $_SESSION['correo'] = $usuario['correo'];
            $_SESSION['telefono'] = $usuario['numero_telefono'];
            $_SESSION['dni'] = $usuario['dni'];

            // Redirigir según el rol del usuario 1 = administrador, 2 = cliente
            if ($usuario['id_rol'] == 1) {
                include(__DIR__ . "/generar_citas.php");
                header("Location: ../front/admin.php");
            } else if ($usuario['id_rol'] == 2) {
                header("Location: ../front/cliente.php");
            } else {
                echo "Rol no reconocido.";
            }
        } else{
            // Contraseña incorrecta
            mysqli_close($conexion);
            header("Location: ../front/login.html?error=Usuario o contraseña incorrectos");
            exit();
        }
    } else {
        // Usuario no encontrado
        mysqli_close($conexion);
        // Redirigir a la página de inicio de sesión con un mensaje de error, en caso de que el usuario no exista o la contraseña sea incorrecta
        header("Location: ../front/login.html?error=Usuario o contraseña incorrectos");
        exit();
    }    
?>
