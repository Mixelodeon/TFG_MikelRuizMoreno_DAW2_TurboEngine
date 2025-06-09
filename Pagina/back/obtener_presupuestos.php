<?php 
    // Verificar si la sesión está iniciada y si el usuario tiene el rol adecuado de cliente (id_rol = 2) o administrador (id_rol = 1)
    if(!isset($_SESSION['id_usuario']) || $_SESSION['id_rol'] != 1 && $_SESSION['id_rol'] != 2) {
            header("Location: ../front/login.html?error=No tienes permiso para acceder");
        exit();
    }
    // Realizar la conexión a la base de datos
    $conexion = mysqli_connect("localhost","root","","turboengine");
    // Verificar si la conexión a la base de datos se realizó correctamente
    if(!$conexion) {
        die("Error en la conexión: " . mysqli_connect_error());
    }
    // Obtener el ID del rol del usuario conectado desde la sesión
    $idRol = $_SESSION["id_rol"];
    // echo $idRol;
    // Si el usuario es cliente (id_rol = 2), entra en esta condición
    if($idRol == 2){
        // Consulta SELECT para obtener los presupuestos del usuario actual y ordenarlos por fecha de solicitud
        $query = "SELECT p.id_presupuesto, u.dni, p.matricula, p.servicio, p.descripcion, p.respuesta, p.fecha_solicitud, p.fecha_respuesta, p.estado, p.precio
            FROM presupuestos p
            JOIN usuarios u ON p.id_usuario = u.id_usuario 
            WHERE p.id_usuario = {$_SESSION['id_usuario']} 
            ORDER BY p.fecha_solicitud DESC";                
        // Ejecutar la consulta
        $resultado = mysqli_query($conexion, $query);
        // Verificar si la consulta se ejecutó correctamente
        if(!$resultado) {
            die("Error en la consulta: " . mysqli_error($conexion));
        }

        // Pintar la tabla con los presupuestos del usuario, se incluye un botón para ver el presupuesto en PDF si ha sido respondido
        while ($row = mysqli_fetch_assoc($resultado)) {
            echo "<tr class='text-center'>
                    <td>{$row['id_presupuesto']}</td>
                    <td>{$row['dni']}</td>
                    <td>{$row['matricula']}</td>
                    <td>{$row['servicio']}</td>
                    <td>{$row['descripcion']}</td>
                    <td>{$row['fecha_solicitud']}</td>
                    <td>{$row['respuesta']}</td>
                    <td>{$row['estado']}</td>
                    <td>{$row['fecha_respuesta']}</td>";
                        // Si el presupuesto ha sido respondido, mostrar el botón para ver el PDF, si no, mostrar "--"
                        if(strtolower($row['estado']) === 'respondido') {
                            echo "<td><a href='../front/generarPDFPresupuesto.php?id_presupuesto={$row['id_presupuesto']}' class='btn btn-success btn-sm me-1'>Ver Presupuesto</a></td>";
                        } else {
                        echo "<td>--</td>";
                    }
                echo "</tr>";
        }
        // Guardar los presupuestos en un array
        $presupuestos = [];
        // Bucle para recorrer los presupuestos y almacenarlos en el array
        while($row = mysqli_fetch_assoc($resultado)) {
            $presupuestos[] = $row;
        }
        // Guardar los presupuestos en la variable de sesión
        $_SESSION['presupuestos'] = $presupuestos;
        mysqli_close($conexion);
    }
    // Si el usuario es administrador (id_rol = 1), entra en esta condición
    if($idRol == 1){
        // Consulta para obtener todos los presupuestos y ordenarlos por estado y fecha de solicitud
        $query = "SELECT p.id_presupuesto, u.dni, p.matricula, p.servicio, p.descripcion, p.respuesta, p.fecha_solicitud, p.fecha_respuesta, p.estado
            FROM presupuestos p
            JOIN usuarios u ON p.id_usuario = u.id_usuario ORDER BY p.estado = 'Pendiente' DESC, p.fecha_solicitud DESC";
        // Ejecutar la consulta 
        $resultado = mysqli_query($conexion, $query);
        // Verificar si la consulta se ejecutó correctamente
        if(!$resultado) {
            die("Error en la consulta: " . mysqli_error($conexion));
        }

        // Pintar la tabla con los presupuestos de todos los usuarios, se incluye un botón para responder el presupuesto y otro para eliminarlo
        while ($row = mysqli_fetch_assoc($resultado)) {
            echo "<tr class='text-center'>
                    <td>{$row['id_presupuesto']}</td>
                    <td>{$row['dni']}</td>
                    <td>{$row['matricula']}</td>
                    <td>{$row['servicio']}</td>
                    <td>{$row['descripcion']}</td>
                    <td>{$row['fecha_solicitud']}</td>
                    <td>{$row['respuesta']}</td>
                    <td>{$row['estado']}</td>
                    <td>{$row['fecha_respuesta']}</td>
                    <td>
                        <form method='POST' action='responderPresupuesto.php' style='display:inline-block;'>
                            <input type='hidden' name='id_presupuesto' value='{$row['id_presupuesto']}' />
                            <button type='submit' class='btn btn-success btn-sm me-1'>Responder</button>
                        </form>
                        <br><br>
                        <form method='POST' action='../back/eliminar_presupuesto.php' style='display:inline-block;'>
                            <input type='hidden' name='id_presupuesto' value='{$row['id_presupuesto']}' />
                            <button type='submit' class='btn btn-danger btn-sm'>Eliminar</button>
                        </form>
                    </td>
                </tr>";
        }
        mysqli_close($conexion);
    }
?>