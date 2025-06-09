<?php
    // Declaración de variables de conexión a la base de datos
    $user = "root";
    $pass = "";
    $host = "localhost";
    $dbname = "turboengine";
    // Conectar a la base de datos
    $connection = mysqli_connect($host, $user, $pass, $dbname);
    // Verificar si la conexión a la base de datos se realizó correctamente
    if(!$connection){
        die("No se ha podido conectar con el servidor: " . mysqli_connect_error());
    }

    // Llamada a los datos del formulario de registro
    $nombre = $_POST["nombre"];
    $apellidos = $_POST["apellidos"];
    $telefono = $_POST["telefono"];
    $correo = $_POST["correo"];
    $dni = $_POST["dni"];
    $nombreUsuario = $_POST["nombreUsuario"];
    $password = $_POST["password"];

    // Escapar caracteres especiales para evitar inyecciones SQL
    $nombre = mysqli_real_escape_string($connection, $nombre);
    $apellidos = mysqli_real_escape_string($connection, $apellidos);
    $telefono = mysqli_real_escape_string($connection, $telefono);
    $correo = mysqli_real_escape_string($connection, $correo);
    $dni = mysqli_real_escape_string($connection, $dni);
    $nombreUsuario = mysqli_real_escape_string($connection, $nombreUsuario);
    $password = mysqli_real_escape_string($connection, $password);
    // Consulta INSERT para agregar un nuevo usuario a la base de datos con los datos proporcionados en el formulario
    $query = "INSERT INTO usuarios (nombre_usuario, dni, contraseña, correo, numero_telefono, nombre, apellidos, id_rol) 
              VALUES ('$nombreUsuario', '$dni', '$password', '$correo', '$telefono', '$nombre', '$apellidos', 2)";
    // Ejecutar la consulta para insertar el nuevo usuario
    if(mysqli_query($connection, $query)){
        // Redirigir a la página de inicio de sesión
        header("Location: ../front/login.html");
        exit();
    } else {
        echo "Error: " . mysqli_error($connection);
    }

    mysqli_close($connection);
?>