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
$_SESSION['tabla_folio'] = $folio_salida;

switch($tipo_auto_salida){
    case "A":
        $tarifaPorHora = 16;
        break;
    case "B":
        $tarifaPorHora = 20;
        break;
    case "C":
        $tarifaPorHora = 30;
        break;
    case "D":
        $tarifaPorHora = 53;
        break;
    default:
        $tarifaPorHora = 16;
        break;
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
$query_delete = "DELETE FROM entradas WHERE folio_entradas=$folio_salida";
$consulta = mysqli_query($conexion,$query);

$rows = $consulta->fetch_assoc();
    $folio_registrar = $rows['folio_entradas'];
    $empleado_registro = $rows['empleado_registro'];
    $usuario_cobro = $username;
    $fecha_entrada_registro = $rows['fecha_entrada'];
    $color_marca = $rows['color_marca'];
$query_insert = "INSERT INTO
                 salidas
                 (id_consecutivo,
                  folio_entrada,
                  atendio,
                  usuario_cobro,
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
                  '$usuario_cobro',
                  '$fecha_entrada_registro',
                  '$hora_entrada_salida',
                  '$color_marca',
                  '$placas_salida',
                  '$tipo_auto_salida',
                  '$salida_auto_hora',
                  '$precioTotal')";
$query_insert_respaldo = "INSERT INTO
    respaldo
        (id_respaldo,
        res_id_folio,
        fecha_registro,
        res_hora_entrada,
        res_hora_salida,
        res_usuario_ingreso,
        res_usuario_cobro,
        res_placas,
        res_color_marca,
        res_tipo,
        res_cobrado)
        VALUES
        (NULL,
        '$folio_registrar',
        '$fecha_entrada_registro',
        '$hora_entrada_salida',
        '$salida_auto_hora',
        '$empleado_registro',
        '$usuario_cobro',
        '$placas_salida',
        '$color_marca',
        '$tipo_auto_salida',
        '$precioTotal')";
$insert_respaldo = mysqli_query($conexion,$query_insert_respaldo);
$insert = mysqli_query($conexion,$query_insert);
$delete = mysqli_query($conexion,$query_delete);
if($insert){
    echo'

        <script>
            window.location = "../index.php";
            window.open("ticket/ticket_salida.php", "_blank");
        </script>
        ';

}
mysqli_close($conexion);
?>