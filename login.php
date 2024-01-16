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
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'><!--Esta es la referencia del icono de pass-->
    <link rel="shortcut icon" href="img/icono.ico" type="image/x-icon">
    <link rel="stylesheet" href="css/style.css">
    <title>Iniciar Sesión</title>
</head>
<body>
    
    <div class="grid-inicio_sesion">
        <div class="titulo_login">
            <p>Antau Estacionamiento</p>
        </div>
    <div class="inicio_sesion">
        <form action="php/login_back.php" method="POST" id="form_login" name="form_login">
            <img src="img/logo.jpg" alt="Logotipo">
            <label for="username">Usuario:</label>
            <input id="username" name="username" type="text"  autocomplete="off" onkeyup="convertirAMinusculas(this);">
            <span class="warnings" id="mensaje_user" name="mensaje_user">Sin caracteres especiales</span>
            <label for="password">Contraseña:</label>
            <div class="pass_cont">
                <input  id="password" name="password" type="password" autocomplete="off" onkeyup="convertirAMinusculas(this);">
                <i class="bx bx-show-alt"></i>
            </div>
            <span class="warnings" name="msg_pass" id="msg_pass">sin caracteres especiales</span>
            <input type="submit" value="Iniciar Sesión">
            
        </form>
        
        </div>
    </div>
    <script src="scripts/validar_login.js"></script>
</body>
</html>