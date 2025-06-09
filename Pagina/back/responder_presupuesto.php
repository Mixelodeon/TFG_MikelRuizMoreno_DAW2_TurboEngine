<?php
    // Iniciar sesión para acceder a las variables de sesión
    session_start();
    // Verificar si el usuario ha iniciado sesión y es un administrador
    if (!isset($_SESSION['id_usuario']) || $_SESSION['id_rol'] != 1) {
        header("Location: ../front/login.html?error=Acceso no autorizado");
        exit();
    }

    // Verificar si se han recibido los datos necesarios del formulario
    if (empty($_POST['id_presupuesto']) || empty($_POST['respuesta'])) {
        header("Location: ../front/gestionPresupuestos.php?error=Datos incompletos");
        exit();
    }
    // Obtener los datos del formulario
    $id_presupuesto = intval($_POST['id_presupuesto']);
    $respuesta = trim($_POST['respuesta']);
    $precio = trim($_POST['precio']);
    // Obtener el ID del usuario de la sesión
    $_SESSION['id_presupuesto'] = $id_presupuesto;
    // Conectar a la base de datos
    $conexion = mysqli_connect("localhost", "root", "", "turboengine");
    // Verificar si la conexión a la base de datos se realizó correctamente
    if (!$conexion) {
        die("Error de conexión: " . mysqli_connect_error());
    }

    // Actualizar la respuesta del presupuesto proporcionada por el administrador
    $query = "UPDATE presupuestos SET respuesta = ?, precio = ?, estado = 'respondido', fecha_respuesta = NOW() WHERE id_presupuesto = ?";
    // Preparar la consulta para evitar inyecciones SQL
    $stmt = mysqli_prepare($conexion, $query);
    // Verificar si la preparación de la consulta fue exitosa
    if ($stmt) {
        // Vincular los parámetros de la consulta
        mysqli_stmt_bind_param($stmt, "sii", $respuesta, $precio, $id_presupuesto);
        // Verificar si la ejecución de la consulta fue exitosa
        if (mysqli_stmt_execute($stmt)) {
            // Consulta SELECT para obtener el correo y nombre del cliente asociado al presupuesto
            $sqlCorreo = "SELECT u.correo, u.nombre FROM presupuestos p JOIN usuarios u ON p.id_usuario = u.id_usuario 
                        WHERE p.id_presupuesto = ?";
            // Preparar la consulta para evitar inyecciones SQL
            $stmtCorreo = mysqli_prepare($conexion, $sqlCorreo);
            // Parametrizar la consulta con el ID del presupuesto
            mysqli_stmt_bind_param($stmtCorreo, "i", $id_presupuesto);
            // Ejecutar la consulta
            mysqli_stmt_execute($stmtCorreo);
            // Obtener el resultado de la consulta
            mysqli_stmt_bind_result($stmtCorreo, $correoCliente, $nombreCliente);
            // Recuperar los datos de la consulta
            mysqli_stmt_fetch($stmtCorreo);
            mysqli_stmt_close($stmtCorreo);
            // Verificar si se obtuvo el correo del cliente, para enviarle una notificación a través de correo electrónico
            if (!empty($correoCliente)) {
                // Preparar el correo electrónico para notificar al cliente sobre la respuesta del presupuesto
                $titulo = "Presupuesto disponible - TurboEngine";
                $mensaje = "
                    <html>
                        <head>
                            <title>Presupuesto disponible</title>
                        </head>
                        <body>
                            <p>Hola <strong>$nombreCliente</strong>:</p>
                            <p>Tu presupuesto ya ha sido respondido por el taller.</p>
                            <p>Puedes consultarlo accediendo a tu cuenta en la web de 
                            <a href='http://localhost/pagina/front/index.html'>TurboEngine</a>.
                            </p>
                            <p>Gracias por confiar en nosotros.<br>- Equipo de TurboEngine</p>
                        </body>
                    </html>
                ";
                // Cabeceras para que el correo se interprete como HTML
                $cabeceras = "MIME-Version: 1.0" . "\r\n";
                $cabeceras .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                $cabeceras .= "From: turboenginework@gmail.com\r\n";
                $cabeceras .= "Reply-To: turboenginework@gmail.com\r\n";
                $correoTaller = "From: turboenginework@gmail.com";
                // Enviar el correo al cliente notificando la respuesta del presupuesto
                mail($correoCliente, $titulo, $mensaje, $cabeceras);
            }
            header("Location: ../front/gestionPresupuestos.php?success=presupuestoRespondido");
        } else {
            header("Location: ../front/gestionPresupuestos.php?error=Error al ejecutar la consulta");
        }
    mysqli_stmt_close($stmt);
    } else {
        header("Location: ../front/gestionPresupuestos.php?error=errorResponderPresupuesto");
    }
    mysqli_close($conexion);
?>
