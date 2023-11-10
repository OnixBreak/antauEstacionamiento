<?php
        session_start();
        include "conexion_back.php";
        $usuario = $_SESSION["username"];
        $delSalidas = "DELETE FROM salidas WHERE usuario_cobro='$usuario'";
        $consult = mysqli_query($conexion,$delSalidas);
        mysqli_close($conexion);
        session_destroy();
        header("location: ../login.php");

?>