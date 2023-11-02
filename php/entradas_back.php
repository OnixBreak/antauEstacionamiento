<?php
session_start();
date_default_timezone_set('America/Mexico_City');
if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
}
include 'conexion_back.php';
$placa_auto = $_POST['placAuto'];
$tipo_auto = $_POST['tipVehiculo'];
$color_marca = $_POST['color_marca'];
$usuario = $_SESSION['username'];

$query = "INSERT INTO entradas( folio_entradas, empleado_registro, fecha_entrada, hora_entrada, color_marca,  placa, tipo_vehiculo) VALUES
(NULL,'$usuario', CURRENT_DATE, CURRENT_TIME, '$color_marca', '$placa_auto','$tipo_auto')";
$registrar_entrada = mysqli_query($conexion, $query);
if($registrar_entrada){
    echo'

        <script>
            window.open("../php/ticket/ticket_entrada.php", "_blank");
            window.location = "../index.php";
        </script>
        ';

}

mysqli_close($conexion);
?>


