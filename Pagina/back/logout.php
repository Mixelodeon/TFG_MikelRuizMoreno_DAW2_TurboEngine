<?php
    // Iniciar sesión y destruirla para cerrar sesión
    session_start();
    // Elimina todas las variables de sesión
    session_unset();
    // Destruye la sesión
    session_destroy();  
    // Redirigir al usuario a la página de inicio de sesión
    header("Location: ../front/login.html"); 
    exit();
?>
