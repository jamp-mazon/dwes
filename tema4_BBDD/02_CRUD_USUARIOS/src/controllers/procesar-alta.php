<?php
session_start();
require_once "../models/basedatos.php";
require_once "../models/Usuario.php";

if ($_SERVER["REQUEST_METHOD"]!="POST") {
    header("Location:../public/index.php");
    die;
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
    $password_claro=$_POST["password"];
    $password=password_hash($password_claro,PASSWORD_DEFAULT);

    $usuario=new Usuario(
        null,
        $nombre,
        $apellidos,
        $user,
        $password,
        new DateTime($fecha_nac)
        
    );
    
    $dbInstacia=BaseDatos::getInstance();
    if($dbInstacia->crear_usuario($usuario)){
        $_SESSION["insert"]="Usuario creado con exito";
    }
    else{
        $_SESSION["insert"]="Fallo al crear el usuario";
    }
    header("Location:../views/listado.php");
    die;

}


?>