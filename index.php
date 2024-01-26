<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/estilos.css">
  <title>Login</title>
  <script src="js/java.js" defer></script>
  <script>
    function checkRememberMe() {
      var rememberMeCheckbox = document.getElementById('recordarme');
      var storedUsername = localStorage.getItem('rememberedUsername');

      if (rememberMeCheckbox.checked && storedUsername) {
        document.getElementById('usuario').value = storedUsername;
      }
    }

    function setRememberMe() {
      var rememberMeCheckbox = document.getElementById('recordarme');
      var usernameInput = document.getElementById('usuario');

      if (rememberMeCheckbox.checked) {
        localStorage.setItem('rememberedUsername', usernameInput.value);
      } else {
        localStorage.removeItem('rememberedUsername');
      }
    }
  </script>
</head>
<body onload="checkRememberMe()">

  <div class="login-container">
    <i class="user-icon fas fa-user-circle"></i>
    <h2>INICIE SESIÓN EN SU CUENTA</h2>
    <form onsubmit="setRememberMe()" action="verificar.php" method="post">
      <input type="text" id="usuario" name="usuario" placeholder="Usuario" required>
      <input type="password" name="contrasena" placeholder="Contraseña" required>
      <button type="submit">Iniciar sesión</button>
      <label>
        <input type="checkbox" id="recordarme" name="recordarme">Recordarme
      </label>
      <a href="registro/registro">Regístrate aquí.</a>
    </form>
    <p>Actualmente Tenemos 3Teras de archivos, Todos los dias Actualisamos con nuevos archivos</p>
  </div>

  <footer>
    <p>&copy; 2024 todos los derechos reservados para RapidFiles.</p>
  </footer>

</body>
</html>
