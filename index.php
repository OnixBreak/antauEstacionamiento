<?php
session_start();
if(!isset($_SESSION['username'])){
  echo '
    <script>
    window.location = "login.php";
    </script>
    ';
    session_destroy();
    die(); 
}
$user_loged = $_SESSION['username'];
include 'php/conexion_back.php';
$nombre_usuario_logeado = mysqli_query($conexion,"SELECT nombreCompleto FROM usuarios WHERE usuario='$user_loged'");
$cargo = mysqli_query($conexion,"SELECT cargo FROM usuarios WHERE usuario='$user_loged'");
$ultimo_folio_registrado = mysqli_query($conexion,"SELECT MAX(folio_entradas) AS ultimo_folio FROM entradas");
$row = $nombre_usuario_logeado -> fetch_assoc();
$folio_ultimo = $ultimo_folio_registrado->fetch_assoc();
$cargo_user = $cargo -> fetch_assoc();
$folio_siguiente = intVal($folio_ultimo['ultimo_folio']) + 1;
mysqli_close($conexion);
$usuario = $_SESSION['username'];

?>
<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/icono.ico" type="image/x-icon">
    <title>Estacionamiento Antau</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="grid-dashboard">
        <navbar class="navbar">
            <img src="img/icono_inicio_sesion.jpg"/>
            <div class="Usuario_iniciado"><p  name="userLoged" id="userLoged">Atiende: <?php echo $row['nombreCompleto'];?></p>
            <p id="cargo_index">Cargo: <?php echo $cargo_user['cargo'];?></p>
            <p>Folio Siguiente: <?php echo $folio_siguiente;?></p>
            </div>
            <img src="img/power.png" id="cerrar_sesion" alt="cerrar sesión">
            <a class="info" href="acercade.html">A cerca de...</a>
        </navbar>
        <div class="wrap">
            <div class="widget">
                <div class="fecha">
                    <p id="diaSemana" class="diaSemana"></p>
                    <p id="dian" class="dian"></p>
                    <p>de </p>
                    <p id="mes" class="mes"></p>
                    <p>del </p>
                    <p id="year" class="year"></p>
                </div>
                    <div class="reloj">
                        <p id="horas" class="horas"></p>
                        <p>:</p>
                        <p id="minutos" class="minutos"></p>
                        <p>:</p>
                            <div class="caja-segundos">
                                <p id="ampm" class="ampm"></p>
                                <p id="segundos" class="segundos"></p>
                            </div>
                    </div>
                </div>
            </div> 
    <div class="ingresar_registro">
        <form class="forms" action="php/entradas_back.php" method="POST" id="form_registro" name="form_registro">
            <p>Ingresar un Registro</p>
            <input type="text" placeholder="Placa" id="placAuto" name="placAuto" autocomplete="off" onkeyup="mayus(this);">
            <span id="p_plac" class="warnings">Solo letras y números</span>
            <input type="text" name="color_marca" id="color_marca" placeholder="Modelo Color" autocomplete="off" onkeyup="mayus(this);">
            <span id="p_color" class="warnings">Solo letras</span>
            <select name="tipVehiculo" id="tipVehiculo">
                <option value="A">Automovil</option>
                <option value="B">Camioneta</option>
                <option value="C">Camioneta 3 1/2</option>
                <option value="D">Camión</option>
                <option value="E">Motocicleta</option>
                <option value="Pension">Pensión</option>
            </select>
            <input type="submit" value="Ingresar Registro" id="imp_ticket_entrada" name="imp_ticket_entrada">

        </form>
    </div>
        <div class="buscar_registro">
            <form class="forms" action="buscar_ticket.php" method="POST" name="form_validar" id="form_validar">
                <p>Buscar Folio</p>
                <input name="folio_a_buscar" id="folio_a_buscar" type="text" placeholder="Folio" autocomplete="off" autofocus>
                <span id="val" class="warnings">Solo números!</span>
                <input type="submit" value="Buscar">
            </form>
        </div>
        <div class="boleto_perdido">
            <form class="forms" action="obtener_datos.php" method="POST">
                <p>Boleto perdido por</p>
                <select name="buscar_por" id="buscar_por">
                    <option value="placa">Placa</option>
                    <option value="color_modelo">Color/Modelo</option>
                    <option value="hora_entrada">Hora</option>
                </select>
            <input name="boleto_perdido_descrip" id="boleto_perdido_descrip" type="text" placeholder="rastrear boleto" autocomplete="off" onkeyup="mayus(this);">
            <input type="submit" value="Buscar">
            </form>
        </div>
        <div class="reimpresión_ticket" id="grid_reimpresion">
        <form  id="form_print"class="forms" action="php/ticket/reimprimir_ticket.php" method="POST">
            <label for="reimpresion">Reimprimir Ticket</label>
            <select name="select_reimpresion" id="select_reimpresion">
                <option value="entrada">Entrada</option>
                <option value="salida">Salida</option>
            </select>
            <input type="text" name="reimpresion" id="reimpresion" placeholder="Folio" autocomplete="off">
            <span id="print" class="warnings">Solo números</span>
            <input type="submit" value="Imprimir">
        </form>
        </div>
    </div>
    <script src="scripts/reloj.js"></script>
<script src="scripts/funct.js"></script>
</body>
</html>
