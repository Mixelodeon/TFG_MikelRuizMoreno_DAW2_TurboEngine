<?php
    // Iniciar sesión para acceder a las variables de sesión
    session_start();

    // Variables con datos de conexión a la base de datos
    $user = "root";
    $pass = "";
    $host = "localhost";
    $dbname = "turboengine";
    // Conectar a la base de datos
    $conexion = mysqli_connect($host, $user, $pass, $dbname);
    // Verificar que la conexión se realizó correctamente
    if (!$conexion) {
        // Si la conexión falla, y el usuario es cliente, redirigir a la página de citas del cliente
        if($_SESSION['id_rol'] == 2){
            header("Location: ../front/clienteVerCitas.php?error=Error de conexión a la base de datos");
            exit();
        }
        // Si la conexión falla, y el usuario es administrador, redirigir a la página de gestión de citas del administrador
        if($_SESSION['id_rol'] == 1){
            header("Location: ../front/gestionCitas.php?error=Error de conexión a la base de datos");
            exit();
        }   
    }

     // Asegurar que se recibió el dato y método correcto
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancelar_cita'])) {
        // Escapar el id de la cita para evitar inyecciones SQL
        $idCita = mysqli_real_escape_string($conexion, $_POST['cancelar_cita']);
        // Consulta SELECT para obtener los datos del cliente asociado a la cita	
        $sqlDatosCliente = "SELECT u.correo, u.nombre
                          FROM citas c 
                          JOIN usuarios u ON c.id_usuario = u.id_usuario 
                          WHERE c.id_cita = '$idCita'";
        // Lanzar la consulta
        $resultadoDatos = mysqli_query($conexion, $sqlDatosCliente);
        // Inicializar variables para almacenar los datos del cliente
        $correoCliente = null;
        $nombreCliente = null;
        // Verificar si se obtuvieron resultados y extraer los datos del cliente
        if(mysqli_num_rows($resultadoDatos) > 0){
            $fila = mysqli_fetch_assoc($resultadoDatos);
            $correoCliente = $fila['correo'];
            $nombreCliente = $fila['nombre'];
        }
        // Consulta UPDATE para cancelar la cita y dejarla disponible
        $query = "UPDATE citas
                SET fecha_solicitud = NULL, id_usuario = NULL, disponible = 1
                WHERE id_cita = '$idCita'";
        // Ejecutar la consulta
        $resultado = mysqli_query($conexion, $query);
        // Si el usuario es cliente, redirigir a la página de citas del cliente
        if($_SESSION['id_rol'] == 2){
            // Verificar si la consulta se ejecutó correctamente
            if ($resultado) {
                mysqli_close($conexion);
                header("Location: ../front/clienteVerCitas.php?success=ExitoCita");
                exit();
            } else { 
                mysqli_close($conexion);
                header("Location: ../front/clienteVerCitas.php?error=ErrorCita");
                exit();
            }
        }
        // Si el usuario es administrador, enviar un correo al cliente y redirigir a la página de gestión de citas del administrador
         if($_SESSION['id_rol'] == 1){
            // Verificar si la consulta se ejecutó correctamente y si se obtuvieron los datos del cliente
            if ($resultado && $correoCliente && $nombreCliente) {
                // Estructura del correo
                $titulo = "Cita Cancelada - TurboEngine";
                $mensaje = "
                    <html>
                        <head>
                            <title>Cita Cancelada</title>
                        </head>
                        <body>
                            <p>Hola <strong>$nombreCliente</strong>:</p>
                            <p>Tu cita en nuestro taller ha sido cancelada.</p>
                            <p>Puede solicitar una nueva cita accediendo a tu cuenta en la web de 
                            <a href='http://localhost/pagina/front/index.html'>TurboEngine</a>.
                            </p>
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
                // Enviar el correo al cliente
                mail($correoCliente, $titulo, $mensaje, $cabeceras);
                mysqli_close($conexion);
                // Redirigir a la página de gestión de citas del administrador con éxito
                header("Location: ../front/gestionCitas.php?success=ExitoCita");
                exit();
            } else { // Si no se pudo enviar el correo o no se obtuvieron los datos del cliente, redirigir con error
                mysqli_close($conexion);
                header("Location: ../front/gestionCitas.php?error=ErrorCita");
                exit();
            }
        }
           

    } else {
        header("Location: ../front/clienteVerCitas.php?error=Solicitud inválida");
        exit();
    }
?>