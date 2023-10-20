<?php
session_start();
if(!isset($_SESSION['username'])){
  echo '
    <script>
    window.location = "index.php";
    </script>
    ';
    session_destroy();
    die(); 
}

$user_loged = $_SESSION['username'];
include 'php/conexion_back.php';
$nombre_usuario_logeado = mysqli_query($conexion,"SELECT nombreCompleto FROM usuarios WHERE usuario='$user_loged'");
$ultimo_folio_registrado = mysqli_query($conexion,"SELECT MAX(folio_entradas) AS ultimo_folio FROM entradas");
$row = $nombre_usuario_logeado -> fetch_assoc();
$folio_ultimo = $ultimo_folio_registrado->fetch_assoc();
$folio_siguiente = intVal($folio_ultimo['ultimo_folio']) + 1;
mysqli_close($conexion);
$usuario = $_SESSION['username'];

?>
<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="css/main.css" type="text/css">
    <link rel="shortcut icon" href="img/icono.ico"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@500&display=swap" rel="stylesheet">
    
    <meta charset="utf-8">

    <title>Estacionamiento ANTAU</title>
  </head>
  <header>
    <div class="menu">
      <button class="btn-adicionales">Opciones</button>
    <div class="menu_desplegable">
      <a id="mostrar_ocultar_salida">Validar Salida</a>
      <a id="mostrar_ocultar_perdido">Boleto perdido</a>
      <a href="#">Pensión</a>
      
    </div>
  </div>
      <a href="php/cerrar_sesion.php">
        <img src="img/power.png"/>
      </a>
  </header>
  <body>
  <div class="Usuario_iniciado"><p>Atiende:</p><p  name="userLoged" id="userLoged"><?php echo $row['nombreCompleto'];?>  ||  Folio Siguiente: <?php echo $folio_siguiente;?></p></div>
    <form  id="busqueda_boleto" class="busqueda" action="buscar_ticket.php" method="post">
    <label for="folio_a_buscar">FOLIO A BUSCAR</label>
    <input id="folio_a_buscar" name="folio_a_buscar" type="text" placeholder="escribe un folio" autocomplete="off"></input>
    <input type="submit" value="Buscar"/>
    </form>
    
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

<!-- Form -->
<form class="registro" action="php/entradas_back.php" method="POST">
  <div  class="grupo_formulario">
  <label for="placAuto">Placas:</label>
    <input name="placAuto"type="text" id="placAuto" placeholder="Escribe la placa" autocomplete="off"/>
    </div>
  <div class="grupo_formulario">
    <label for="color_marca">Color / Marca:</label>
   <input name="color_marca" id="color_marca" type="text" placeholder="Marca Color" autocomplete="off"/>
    </div><div class="grupo_formulario">
   <label for="tipVehiculo">Vehículo Tipo:</label>
    <select name="tipVehiculo" id="tipVehiculo">
      <option value="A">A</option>
      <option value="B">B</option>
      <option value="C">C</option>
      <option value="D">D</option>
      <option value="E">Pensión</option>
    </select>
    </div>
    <div>
      <input name="imp_ticket_entrada" id="imp_ticket_entrada" type="submit" value="Imprimir Ticket"/>
    </div>
  </form>
  <div class="boleto_perdido" id="boleto_perdido">
    <form action="obtener_datos.php" method="POST">
      <p>Boleto extraviado</p>
      <p>Buscar por:</p>
      <select id="buscar_por" name="buscar_por">
        <option value="folio">Folio</option>
        <option value="placa">Placa</option>
        <option value="color/marca">Color/Marca</option>
        <option value="verregistros">Ver todo</option>
      </select>
      <input  id="boleto_perdido_descrip" name="boleto_perdido_descrip" type="text" autocomplete="off"/>
      <input type="submit" value="Buscar">
      <a href="aviso.html">Aviso importante</a>
    </form>
  </div>
  <script src="scripts/main.js"></script> 
  <script src="scripts/reloj.js"></script>
  </body>
</html>