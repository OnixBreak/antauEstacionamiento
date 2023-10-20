<?php
session_start();
if(!isset($_SESSION['username'])){
  echo '
    <script>
    alert("Tienes que iniciar sesión!");
    window.location = "index.php";
    </script>
    ';
    session_destroy();
    die();
}
?>

<!DOCTYPE html>
<html lang="es-MX">
<head>
    <link rel="stylesheet" href="css/main.css">
    <link rel="shortcut icon" href="./img/icono.ico" type="image/x-icon">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados de la búsqueda</title>
</head>
<body>

    <div class="btn_regresar">
        <a href="main.php"><<</a>
    </div>

    <p id="titulo-tabla-registros_devueltos">Estos registros han sido encontrados</p>
    <div class="tabla_registros_devueltos">
    <table>
        <tr>
            <th>Folio</th>
            <th>Atendió</th>
            <th>Fecha de Entrada</th>
            <th>Hora de entrada</th>
            <th>Color / Marca</th>
            <th>Placa</th>
            <th>Tipo de vehículo</th>
    </tr>
    <?php
include 'php/conexion_back.php';
$consulta_boleto_perdido = "SELECT * FROM entradas";
$select_boletoperdido_buscar = $_POST['buscar_por'];
$valor_boletoperdido_buscar = $_POST['boleto_perdido_descrip'];

if($select_boletoperdido_buscar ==""){
   $select_boletoperdido_buscar = "verregistros"; 
}
if($valor_boletoperdido_buscar ==""){
    $select_boletoperdido_buscar="verregistros";
}


switch ($select_boletoperdido_buscar) {
    case 'folio':
        $consulta_boleto_perdido = "SELECT * FROM entradas WHERE folio_entradas='$valor_boletoperdido_buscar'";
        break;
    
    case 'placa':
        $consulta_boleto_perdido = "SELECT * FROM entradas WHERE placa='$valor_boletoperdido_buscar'";
        break;
    case 'color/marca':
        $consulta_boleto_perdido = "SELECT * FROM entradas WHERE color_marca='$valor_boletoperdido_buscar'";
        break;
    case 'verregistros':
        $consulta_boleto_perdido = "SELECT * FROM entradas";

    default:
        echo'
        <script>
        </script>';
        break;
        
}
$result = mysqli_query($conexion,$consulta_boleto_perdido);

while($row = $result->fetch_array()){
?>
<tr>
        <td><?php echo $row['folio_entradas']?></td>
        <td><?php echo $row['empleado_registro']?></td>
        <td><?php echo $row['fecha_entrada']?></td>
        <td><?php echo $row['hora_entrada']?></td>
        <td><?php echo $row['color_marca']?></td>
        <td><?php echo $row['placa']?></td>
        <td><?php echo $row['tipo_vehiculo']?></td>
</tr>

        <?php
}
mysqli_close($conexion);
        ?>
    </table>
    </div>
</body>
</html>