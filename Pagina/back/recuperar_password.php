<?php 
    // Obtenemos los datos del formulario de recuperación de contraseña
    $usuario = trim(strtolower($_POST['usuario']));
    $correo = trim(strtolower($_POST['correo']));
    // Declaración de variables de conexión a la base de datos
    $host = "localhost";
    $user = "root";
    $pass = "";
    $dbname = "turboengine";
    // Conectar a la base de datos
    $conexion = mysqli_connect($host, $user, $pass, $dbname);
    // Consulta SELECT para obtener los datos del usuario por correo y nombre de usuario
    $sqlDatosCliente = "SELECT id_usuario, nombre, correo, nombre_usuario FROM usuarios 
                        WHERE correo = '$correo' AND nombre_usuario = '$usuario'";
    // Ejecutar la consulta
    $resultado = mysqli_query($conexion, $sqlDatosCliente);
    // Declarar variables para almacenar los datos del usuario
    $idUsuario = null;
    $correoCliente = null;
    $nombreCliente = null;
    // Verificar si la consulta se ejecutó correctamente y si se encontraron resultados, almacenar los datos del usuario en variables
    if(mysqli_num_rows($resultado) > 0){
        $fila = mysqli_fetch_assoc($resultado);
        $idUsuario = $fila['id_usuario'];
        $correoCliente = $fila['correo'];
        $nombreCliente = $fila['nombre'];
        $usuario = $fila['nombre_usuario'];
    }
    // Generar un token único para el restablecimiento de contraseña, este será pasado al usuario por correo electrónico
    $token = bin2hex(random_bytes(16));
    // Establecer la fecha de expiración del token, en este caso 1 hora a partir de cuando se genera
    $expires = date("Y-m-d H:i:s", strtotime('+1 hour'));
    // Insertar token en la tabla reset_tokens, mediante una consulta INSERT a la base de datos
    $sqlInsertToken = "INSERT INTO reset_tokens (id_usuario, token, expiracion_token) VALUES ('$idUsuario', '$token', '$expires')";
    // Ejecutar la consulta para insertar el token
    mysqli_query($conexion, $sqlInsertToken);
    // Verificar si la consulta se ejecutó correctamente
    if (!$resultado) {
        die("Error en la consulta: " . mysqli_error($conexion));
    }
    // Almacenar el número de filas devueltas por la consulta, para verificar si se encontró un usuario con el correo y nombre de usuario proporcionados
    $nr = mysqli_num_rows($resultado);
    // Verificar si se encontró un usuario con el correo y nombre de usuario proporcionados
    if ($nr != 0 && $correoCliente && $nombreCliente) {
        // $mostrar = mysqli_fetch_array($resultado);
        // Preparar el correo electrónico para enviar al usuario con el enlace para restablecer la contraseña
        $titulo = "Cambio de Contraseña - TurboEngine";
        $mensaje = "
            <html>
                <head>
                    <title>Cambio de Contraseña</title>
                </head>
                <body>
                    <p>Hola <strong>$nombreCliente</strong>:</p>
                    <p>Has solicitado un cambio de contraseña.</p>
                    <p>Para restablecer tu contraseña, accede al siguiente enlace:</p>
                    <!-- Se envia el token en la URL -->
                    <p><a href='http://localhost/pagina/front/formularioPassword.php?token=$token'>Haz clic aquí para restablecerla</a></p>
                    <p>Este enlace expirará en 1 hora.</p>
                    <p>Un saludo.<br>- Equipo de TurboEngine</p>
                </body>
            </html>
        ";
        // Cabeceras para que el correo se interprete como HTML
        $cabeceras = "MIME-Version: 1.0" . "\r\n";
        $cabeceras .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $cabeceras .= "From: turboenginework@gmail.com\r\n";
        $cabeceras .= "Reply-To: turboenginework@gmail.com\r\n";
        $correoTaller = "From: turboenginework@gmail.com";
        // Enviar el correo electrónico al usuario con el enlace para restablecer la contraseña
        if(mail($correoCliente, $titulo, $mensaje, $cabeceras)) {
            // Redirigir al usuario a la página de login con un mensaje de éxito
            header("Location: ../front/login.html?success=correoEnviadoCambioPassword");
        } else {
            echo "Error al enviar el correo.";
        }
    } else {
        echo "No se encontró ningún usuario con ese correo electrónico.";
    }
?>