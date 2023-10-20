<?php
session_start();
date_default_timezone_set('America/Mexico_City');
if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
}


$folio_salida = $_POST['tabla_folio'];
$placas_salida = $_POST['tabla_placa'];
$tipo_auto_salida = $_POST['tabla_tipo_vehiculo'];
$hora_entrada_salida = $_POST['tabla_hora_entrada'];

if($tipo_auto_salida == "A"){
    $tarifaPorHora = 16;
}
else{
    $tarifaPorHora = 20;
}


//Prueba horas
$salida_auto_hora = date("H:i:s");

//calculo aquí
$hora_entrada_format = DateTime::createFromFormat('H:i:s', $hora_entrada_salida);
$hora_salida_format = DateTime::createFromFormat('H:i:s', $salida_auto_hora);

// Calcula la diferencia de tiempo
$intervalo = $hora_salida_format->diff($hora_entrada_format);

// Obtiene las horas de diferencia redondeando hacia arriba
$diferenciaHoras = ceil($intervalo->h + ($intervalo->i / 60) + ($intervalo->s / 3600));

// Calcula el costo total
$costoTotal = $diferenciaHoras * $tarifaPorHora;

// Verifica que el costo no sea 0
if ($costoTotal == 0) {
    $costoTotal = $tarifaPorHora;
}

$precioTotal = $costoTotal;


include 'conexion_back.php';
$query = "SELECT * FROM entradas WHERE folio_entradas=$folio_salida";

$consulta = mysqli_query($conexion,$query);

$rows = $consulta->fetch_assoc();
    $folio_registrar = $rows['folio_entradas'];
    $empleado_registro = $rows['empleado_registro'];
    $fecha_entrada_registro = $rows['fecha_entrada'];
    $color_marca = $rows['color_marca'];
$query_insert = "INSERT INTO
                 salidas
                 (id_consecutivo,
                  folio_entrada,
                  atendio,
                  fecha_entrada,
                  hora_entrada,
                  color_marca,
                  placas,
                  tipo_vehiculo,
                  salida,
                  total)
                  VALUES
                  (NULL,
                  '$folio_registrar',
                  '$empleado_registro',
                  '$fecha_entrada_registro',
                  '$hora_entrada_salida',
                  '$color_marca',
                  '$placas_salida',
                  '$tipo_auto_salida',
                  '$salida_auto_hora',
                  '$precioTotal')";
$insert = mysqli_query($conexion,$query_insert);
if($insert){
    echo'

        <script>
            window.location = "../main.php";
            window.open("ticket/ticket_salida.php", "_blank");
        </script>
        ';

}
mysqli_close($conexion);
?>