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
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="./img/icono.ico" type="image/x-icon">
    <meta charset="UTF-8">
    <title>Resultados de la búsqueda</title>
</head>
<body>
    <div class="btn_regresar">
        <a href="index.php">
        <img src="img/atras.png" alt="Regresar">
        </a>

    </div>
    <div class="grid_boleto_perdido">
        <div class="titulo_boleto_perdido">
        
            <p>Estos registros han sido encontrados</p>
            <button class="btn" id="ticket_boleto_perdido">Imprimir Aviso!</button>
            
        </div>
        <div class="datos_boleto_perdido">
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
        </div>

</div>
<script src="scripts/btnperdido.js"></script>
</body>
</html>
