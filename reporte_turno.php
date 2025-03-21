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
?>
<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de turno</title>
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <link rel="shortcut icon" href="img/icono.ico" type="image/x-icon">
</head>
<body>
<div class="btn_regresar">
                <a href="index.php">
                    <img src="img/atras.png" alt="Regresar">
                </a>
                </div>
    <div class="grid_reporte">
            <div class="title_turno">
                <img src="img/logo.jpg">
                <h1 id="usuario">Registros de: <?php echo $_SESSION['username'] ?></h1>
            </div>
        <div class="registros_turno">
                <table id="datos_reporte">
                    <tr>
                        <th>Folio</th>
                        <th>Atendió</th>
                        <th>Fecha Entrada</th>
                        <th>Hora Entrada</th>
                        <th>Hora Salida</th>
                        <th>Marca/Color</th>
                        <th>Placas</th>
                        <th>Tipo</th>
                        <th>Cobrado</th>
                    </tr>
                    <?php
            include 'php/conexion_back.php';
            $usuario = $_SESSION['username'];
            $consulta_turno = "SELECT * FROM salidas WHERE usuario_cobro='$usuario'";
            $result = mysqli_query($conexion,$consulta_turno);
            if ($result->num_rows > 0) {
                $cantidad_campos = $result->num_rows;
            }
            $suma = 0;
            while($row = $result->fetch_array()){
                $suma += $row['total'];
            ?>
            <tr>
                    <td><?php echo $row['folio_entrada']?></td>
                    <td><?php echo $row['atendio']?></td>
                    <td><?php echo $row['fecha_entrada']?></td>
                    <td><?php echo $row['hora_entrada']?></td>
                    <td><?php echo $row['salida']?></td>
                    <td><?php echo $row['color_marca']?></td>
                    <td><?php echo $row['placas']?></td>
                    <td><?php echo $row['tipo_vehiculo']?></td>
                    <td>$<?php echo $row['total']?>.00</td>
            </tr>
            
                    <?php
            }
            mysqli_close($conexion);
                    ?>
                </table>
                
        </div>
        
        <div class="footer_turno">
        <!--<button id="pdf_turno" class="btn">Generar PDF</button>-->
            <form action="php/cerrar_sesion.php" method="POST" id="formturno">
            <label for="p_regis">Autos registrados</label>
                <input type="text" name="p_regis" id="p_regis" value="<?php echo $cantidad_campos?>" readonly/>
            <label for="p_corte">Corte</label>
                <input type="text" name="p_corte" id="p_corte" value="<?php echo $suma;?>" readonly/>
               
              <input type="submit" value="Cerrar sesión" class="btn" id="cerrar_sesionbtn">
            </form>
    
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js" integrity="sha512-qZvrmS2ekKPF2mSznTQsxqPgnpkI4DNTlrdUmTzrDgektczlKNRRhy5X5AAOnx5S09ydFYWWNSfcEqDTTHgtNA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.7.1/jspdf.plugin.autotable.min.js"></script>
    <script src="scripts/reportPDF.js"></script>
</body>
</html>