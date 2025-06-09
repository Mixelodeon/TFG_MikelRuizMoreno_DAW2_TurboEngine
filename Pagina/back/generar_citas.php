<?php
    // Declaracion de variables de conexión a la base de datos
    $user = "root";
    $pass = "";
    $host = "localhost";
    $dbname = "turboengine";
    // Conectar a la base de datos
    $conexion = mysqli_connect($host, $user, $pass, $dbname);
    
    // Verificar si la conexión a la base de datos se realizó correctamente
    if (!$conexion) {
        die("Error de conexión: " . mysqli_connect_error());
    }

    // Definir fecha: Actual fecha de entorno de pruebas
    $hoy = new DateTime('2025-06-15');    
    // Generar la fecha actual
    // $hoy = new DateTime();
    // Format, convierte el objeto DateTime a una cadena de texto String
    // 'd' = día del mes (01 a 31)
    // Si el día del mes no es 15, no se generan citas
    if ($hoy->format('d') < 15) {
        header("Location: ../front/admin.php?success=Hoy no es 15, no se generan citas.");
    }

    // SQL DE ENTORNO DE PRUEBAS
    // Borrar todas las citas
    // DELETE FROM citas;
    // Reiniciar el autoincremento de citas
    // ALTER TABLE citas AUTO_INCREMENT = 1;

    // Modify: cambia la fecha del objeto DateTime, sumando o restando tiempo, o cambiando partes especificas de la fecha.
    // Suma un mes a la fecha actual
    $siguienteMes = (clone $hoy)->modify('+1 mes');
    // Año 'Y' con 4 digiitos y mes 'm' con 2 dígitos
    $año = $siguienteMes->format('Y');
    $mes = $siguienteMes->format('m');
    // Crear un objeto DateTime para el primer día del mes
    $start = new DateTime("$año-$mes-01");
    // Devuelve el total de días del mes, 't' = total de días del mes
    $end = new DateTime("$año-$mes-" . $start->format('t'));
    // Fechas para condicionar que no se repitan citas
    $startStr = $start->format('Y-m-d');
    $endStr = $end->format('Y-m-d');

    // Verificar que no se hayn generado citas para el mes actual
    // Consulta SELECT para contar las citas ya generadas en el mes
    $sqlCheck = "SELECT COUNT(*) FROM citas WHERE fecha_cita BETWEEN ? AND ?";
    // Preparar la consulta
    $stmtCheck = mysqli_prepare($conexion, $sqlCheck);
    // Verificar si la preparación de la consulta fue exitosa
    mysqli_stmt_bind_param($stmtCheck, "ss", $startStr, $endStr);
    // Ejecutar la consulta
    mysqli_stmt_execute($stmtCheck);
    // Obtener el resultado de la consulta
    mysqli_stmt_bind_result($stmtCheck, $count);
    // Recuperar el resultado de la consulta
    mysqli_stmt_fetch($stmtCheck);
    // Cerrar la declaración de la consulta
    mysqli_stmt_close($stmtCheck);
    // Si ya existen citas para el mes, no se generan más
    if ($count > 0) {
        header("Location: ../front/admin.html?error=Las citas ya han sido generadas para el mes $mes/$año.");
    }

    // Si no existen citas, procede a generarlas
    $comienzoFestivos = new DateTime("$año-12-24");
    // Incluye hasta el 2 de enero del año siguiente
    $finFestivos = new DateTime(($año + 1) . "-01-02");
    // Mes de agosto, para no generar citas ese mes
    $mesAgosoto = '08';
    // Horarios disponibles para las citas
    $horarios = ['08:00' ,'09:00', '10:00', '11:00', '12:00', '16:00', '17:00'];
    // Consulta SQL para insertar las citas a la base de datos
    $sqlInsert = "INSERT INTO citas (disponible, fecha_cita, hora_cita, fecha_solicitud, id_usuario) 
                     VALUES (1, ?, ?, NULL, NULL)";
    // Preparar la consulta SQL
    $stmt = mysqli_prepare($conexion, $sqlInsert);
    // Se clona el objeto DateTime para evitar modificar el original
    // El bucle itera sobre cada día del mes
    for ($date = clone $start; $date <= $end; $date->modify('+1 day')) {
        // Devuelve el numero de dia en formato numerico, 1 = lunes, 7 = domingo
        $diasDeSemana = $date->format('N');
        // Saltar sabado y domingo, si es mayor o igual a 6, es sábado o domingo
        if ($diasDeSemana >= 6) continue;
        // Obtener el numeoro del mes actual, 01 = enero, 12 = diciembre
        $currentmes = $date->format('m');
        // Saltar agosto
        if ($currentmes == $mesAgosoto) continue;
        // Saltar semana de navidad
        if ($date >= $comienzoFestivos && $date <= $finFestivos){
            continue;
        }
        
        foreach ($horarios as $hora) {
            // Formatear la fecha en el siguiente formato: '2025-04-19'
            $fecha = $date -> format("Y-m-d");

            mysqli_stmt_bind_param($stmt, "ss", $fecha, $hora);
            mysqli_stmt_execute($stmt);
        }
    }

    echo "Citas generadas para $mes/$año.";

    mysqli_stmt_close($stmt);
    mysqli_close($conexion);
?>
