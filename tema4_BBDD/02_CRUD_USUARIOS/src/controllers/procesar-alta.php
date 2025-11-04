<?php
session_start();
require_once "../models/basedatos.php";
require_once "../models/Usuario.php";

if ($_SERVER["REQUEST_METHOD"]!="POST") {
    header("Location:../public/index.php");
}
else{
    
    if (!isset($_SESSION["conectado"]) || !$_SESSION["conectado"]) {
    header("Location:../../public/index.php");
    die;
    }
    $nombre=$_POST["nombre"];
    $apellidos=$_POST["apellidos"];
    $user=$_POST["usuario"];
    $fecha_nac=$_POST["fecha_nac"];
    $password=$_POST["password"];

    $usuario=new Usuario(
        null,
        $nombre,
        $apellidos,
        $user,
        new DateTime($fecha_nac),
        password_hash($password,PASSWORD_DEFAULT)
    );
    
    //$dbInstacia=BaseDatos::getInstance();

}


?>