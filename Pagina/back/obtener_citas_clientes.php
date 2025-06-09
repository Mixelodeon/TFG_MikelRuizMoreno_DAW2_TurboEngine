<?php 
    // Declaracion de variable con el id del rol del usuario, obtenido de la sesión
    $idrol = $_SESSION["id_rol"];
    // Comprobar si la sesión está iniciada y si el usuario tiene el rol de cliente (id_rol = 2) o administrador (id_rol = 1)
    if(!isset($_SESSION['id_usuario']) || $_SESSION['id_rol'] != 2 && $_SESSION['id_rol'] != 1) {
            header("Location: ../front/login.html?error=No tienes permiso para acceder");
        exit();
    }
    // Conectar a la base de datos
    $conexion = mysqli_connect("localhost","root","","turboengine");
    // Verificar si la conexión a la base de datos se realizó correctamente
    if(!$conexion) {
        die("Error en la conexión: " . mysqli_connect_error());
    }
    // Si el usuario es cliente (id_rol = 2), entra en esta condición
    if($idrol == 2){
        // Consulta SELECT para obtener las citas del usuario actual
        $query = "SELECT fecha_cita, hora_cita, fecha_solicitud, id_usuario, id_cita
            FROM citas 
            WHERE id_usuario = {$_SESSION['id_usuario']}";                
        // Ejecutar la consulta
        $resultado = mysqli_query($conexion, $query);
        // Verificar si la consulta se ejecutó correctamente
        if(!$resultado) {
            die("Error en la consulta: " . mysqli_error($conexion));
        }
        // Pintar la tabla con las citas del usuario, se incluye un botón para cancelar la cita
        while ($row = mysqli_fetch_assoc($resultado)) {
            echo "<tr class='text-center'>
                <td>{$row['fecha_cita']}</td>
                <td>{$row['hora_cita']}</td>
                <td>{$row['fecha_solicitud']}</td>
                <td>
                    <form method='POST' action='../back/cancelar_cita.php' style='display:inline-block;'>
                        <input type='hidden' name='cancelar_cita' value='{$row['id_cita']}' />
                        <button type='submit' class='btn btn-danger btn-sm'>Cancelar</button>
                    </form>
                </td>
            </tr>";
        }
    }
    // Si el usuario es administrador (id_rol = 1), entra en esta condición
    if($idrol == 1){
        // Consulta para obtener todas las citas no disponibles (reservadas) y ordenarlas por fecha y hora
        $sqlDisponibles = "SELECT * FROM citas WHERE disponible = 0 AND id_usuario IS NOT NULL ORDER BY fecha_cita, hora_cita";
        // Ejecutar la consulta
        $resultado = mysqli_query($conexion, $sqlDisponibles);
        // Verificar si la consulta se ejecutó correctamente
        if (mysqli_num_rows($resultado) > 0) {
            // Pintar la tabla con las citas no disponibles, se incluye un botón para cancelar la cita
            while ($row = mysqli_fetch_assoc($resultado)) {
                echo "<tr class='text-center'>";
                    echo "<td>{$row['id_cita']}</td>";
                    echo "<td>" . ($row['disponible'] == 1 ? 'Sí' : 'No') . "</td>";
                    echo "<td>{$row['fecha_cita']}</td>";
                    echo "<td>{$row['hora_cita']}</td>";
                    echo "<td>{$row['fecha_solicitud']}</td>";
                    echo "<td>{$row['id_usuario']}</td>";
                    echo "<td>";
                        echo "<form method='POST' action='../back/cancelar_cita.php' style='display:inline-block;'>";
                        echo "<input type='hidden' name='cancelar_cita' value='{$row['id_cita']}' />";
                        

                        echo "<button type='submit' class='btn btn-danger btn-sm'>Cancelar</button>";
                        echo "</form>";
                    echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "No hay citas registradas.";
        }

        mysqli_close($conexion);
    }
?>