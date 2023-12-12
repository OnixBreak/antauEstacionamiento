<?php
        session_start();
        include 'conexion_back.php';
        $usuario = $_SESSION['username'];
        $autos_ingresados = $_POST['p_regis'];
        $dinero_corte = (int)$_POST['p_corte'];
        if($dinero_corte>0){
                $insert_corte = "INSERT INTO cortes (id_corte,usuario_corte,fecha_corte,hora_corte,autos_ingresados,dinero_corte) VALUES (NULL,'$usuario',CURRENT_DATE, CURRENT_TIME,'$autos_ingresados','$dinero_corte')";
                $query_datos = mysqli_query($conexion,$insert_corte);
                $delSalidas = "DELETE FROM salidas WHERE usuario_cobro='$usuario'";
                $consult = mysqli_query($conexion,$delSalidas);
                mysqli_close($conexion);
                session_destroy();
                header("location: ../login.php");
        }
        else{
                session_destroy();
                header("location: ../login.php");
        }
?>