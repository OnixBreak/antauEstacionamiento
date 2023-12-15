<?php
session_start();
date_default_timezone_set('America/Mexico_City');
include 'php/conexion_back.php';
$user_loged = $_SESSION['username'];
$nombre_usuario_logeado = mysqli_query($conexion,"SELECT nombreCompleto FROM usuarios WHERE usuario='$user_loged'");
$row = $nombre_usuario_logeado -> fetch_assoc();
$folio_a_buscar = $_POST['folio_a_buscar'];
$query_ticket = "SELECT * FROM entradas WHERE folio_entradas='$folio_a_buscar'" ;

$consultar_datos = mysqli_query($conexion, $query_ticket);

if($consultar_datos->num_rows >0){
    $rowdatos = $consultar_datos -> fetch_assoc();
    $tabla_placa = $rowdatos['placa'];
    $tabla_hora_entrada = $rowdatos['hora_entrada']; 
    $tipo_auto = $rowdatos['tipo_vehiculo'];
}
else{
    echo "<script>
    alert('No se encontraron resultados!');
    </script>";
    header("location: ./index.php");
    exit;
}
mysqli_close($conexion);
?>
<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css" type="text/css"/>
    <link rel="shortcut icon" href="img/icono.ico"/>

        <title>Validar salida</title>
    </head> 
    <body>
        <div class="grid_datos_validar">
            <div class="btn_regresar">
                <a href="index.php">
                    <img src="img/atras.png" alt="Regresar">
                </a>
                </div>
                

            <div class="titulo_validar">
                <h1>Atiende:</h1><h1><?php echo $row['nombreCompleto'];?></h1>
            </div>
            <div class="tabla_datos_validar">
                <div class="consultas_ticket">
                    <form action="php/ingresar_registros_salida.php" method="POST">
                        
                                <label for="tabla_folio">Folio</label>
                                <input type="text" id="tabla_folio" name="tabla_folio" value="<?php echo $folio_a_buscar?>" readonly>
                                <label for="tabla_placa">Placa</label>
                                <input type="text" id="tabla_placa" name="tabla_placa" value="<?php echo $tabla_placa?>" readonly>
                                <label for="tabla_tipo_vehiculo">Tipo de Vehículo</label>
                                <input type="text" id="tabla_tipo_vehiculo" name="tabla_tipo_vehiculo" value="<?php echo $tipo_auto?>" readonly>
                                <label for="tabla_hora_entrada">Hora de entrada</label>
                                <input type="text" id="tabla_hora_entrada" name="tabla_hora_entrada" value="<?php echo $tabla_hora_entrada?>" readonly>
                        <input type="submit" id="ingresar_registros_salidabtn" value="Pagar">
                    </form>
                </div>

            </div>
        </div>
    </body>
</html>




