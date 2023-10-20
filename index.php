<?php
session_start();

if(isset($_SESSION['username'])){
  header("location: main.php");
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Estacionamiento ANTAU</title>
    <link rel="stylesheet" href="css/main.css" type="text/css">
    <link rel="shortcut icon" href="img/icono.ico"/>
  </head>
  
  <body>

    <div class="login-box">
      <img src="img/logo.jpg" class="avatar" alt="Avatar Image">
      <h1>ESTACIONAMIENTO ANTAU</h1>
      <form  action="php/login_back.php" method="POST">
        <!-- username input -->
        <label for="username">Usuario:</label>
        <input id="username" name="username" type="text" placeholder="Ingresa tu usuario" autocomplete="off" require_once>
        <!-- password input -->
        <label for="password">Contraseña:</label>
        <input id="password" name="password" type="password" placeholder="Ingresa tu contraseña" autocomplete="off" require_once>
        <input name="inicio_sesion" id="inicio_sesion" type="submit" value="Ingresar"/>
      
      </form>
    </div>
    <script src="scripts/main.js"></script>
  </body>
</html>


<!--By Onix-->