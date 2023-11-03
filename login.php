<?php
session_start();

if(isset($_SESSION['username'])){
  header("location: index.php");
}
?>
<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/img/icono.ico" type="image/x-icon">
    <link rel="stylesheet" href="css/style.css">
    <title>Iniciar Sesión</title>
</head>
<body>
    <div class="grid-inicio_sesion">
        
    <div class="inicio_sesion">
        <form action="php/login_back.php" method="POST" id="form_login" name="form_login">
            <img src="img/icono_inicio_sesion.jpg" alt="Logotipo">
            <label for="username">Usuario:</label>
            <input id="username" name="username" type="text"  autocomplete="off">
            <span class="warnings" id="mensaje_user" name="mensaje_user">Escribe tu usuario!</span>
            <label for="password">Contraseña:</label>
            <input  id="password" name="password" type="password"name="pass_inicio_sesion" id="pass_inicio_sesion" autocomplete="off">
            <span class="warnings" name="msg_pass" id="msg_pass">Escribe tu Contraseña!</span>
            <input type="submit" value="Iniciar Sesión">
            
        </form>
        </div>
    </div>
    <script src="scripts/validar_login.js"></script>
</body>
</html>