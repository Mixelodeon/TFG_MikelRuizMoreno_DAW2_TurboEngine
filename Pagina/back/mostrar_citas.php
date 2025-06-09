<?php
    // Definir el tipo de contenido como JSON
    header('Content-Type: application/json');
    // Declaración de variables de conexión a la base de datos
    $host = "localhost";
    $user = "root";
    $pass = "";
    $dbname = "turboengine";
    // Conectar a la base de datos
    $conexion = mysqli_connect($host, $user, $pass, $dbname);
    // Verificar si la conexión a la base de datos se realizó correctamente
    if(!$conexion) {
        // Si la conexión falla, se envía un mensaje de error
        die("Error de conexión: " . mysqli_connect_error());
    }
    // Consulta SELECR para obtener las citas disponibles
    $sqlDisponibles = "SELECT fecha_cita, hora_cita FROM citas WHERE disponible = 1 AND id_usuario IS NULL ORDER BY fecha_cita, hora_cita";
    // Ejecutar la consulta
    $resultado = mysqli_query($conexion, $sqlDisponibles);
    // Declarar un array para almacenar las citas
    $citas = [];
    // Verificar si la consulta se ejecutó correctamente
    while($fila = mysqli_fetch_assoc($resultado)) {
        // Obtener la fecha y hora de la cita y almacenarlas en variables
        $fecha = $fila["fecha_cita"];
        $hora = $fila["hora_cita"];
        // Si la fecha no existe en el array, se introduce como una nueva clave
        if (!isset($citas[$fecha])) {
            $citas[$fecha] = [];
        }
        // Añadir la hora a la lista de horas para esa fecha
        $citas[$fecha][] = $hora;
    }
    
    echo json_encode($citas);
    mysqli_close($conexion);
?>