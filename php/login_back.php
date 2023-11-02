<?php
session_start();
include 'conexion_back.php';
$userloged = $_POST['username'];
$userpass = $_POST['password'];
$queryinit = "SELECT * FROM usuarios WHERE usuario='$userloged' AND pass='$userpass'";

$validar_login = mysqli_query($conexion, $queryinit);

if(mysqli_num_rows($validar_login) > 0){
    $_SESSION['username'] = $userloged;

    header("location: ../index.php");

    exit;

}else{
    echo'
        <script>
        alert("Usuario o contraseña incorrectos!");
        window.location = "../login.php";
        </script>
        ';
        exit;
}