<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link rel="icon" type="image/x-icon" href="../assets/Logo1.jpeg" />
  <link rel="stylesheet" href="../css/styleFormsLogin.css">
  <script src="../js/validarCambioPassword.js"></script>
  <title>Login</title>
</head>
<body>
  <div class="login-container">
    <h2>Recuperación de Contraseña</h2>
    <form id="loginForm" action="../back/cambiar_password.php" method="post">
      <div class="form-group">
        <input type="hidden" name="token" id="token" />
        <label for="nuevaPassword">Nueva contraseña:</label>
        <input type="password" name="nuevaPassword" id="nuevaPassword" placeholder="Introduce la nueva contraseña deseada..." required />
        <p id="errorPassword"></p>
        <br>
        <label for="nuevaPasswordConfirm">Vuelva a introducir la contraseña:</label>
        <input type="password" name="nuevaPasswordConfirm" id="nuevaPasswordConfirm" placeholder="Confirme la contraseña..." required />
        <p id="errorComprobacion"></p>
      </div>
      <button type="submit" class="btn" id="botonCambiar">Cambiar</button>
    </form>
  </div>

  <script>
    const params = new URLSearchParams(window.location.search);
    document.querySelector('input[name="token"]').value = params.get('token');
</script>


</body>
</html>
