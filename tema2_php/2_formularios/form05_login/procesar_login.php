<?php
require_once("includes/funciones.php");
include_once("modelo/usuario.php");
if ($_SERVER["REQUEST_METHOD"] !="POST") {
    header("Location: index.php");
    die;
}
else{
    $mensaje="";

    $email=recoge("email");
    $password=recoge("password");

    //Comprobaciones
    if ($email==null || $password==null) {
        $mensaje="ERROR:los campos no pueden estar vacios...";
        header("Location: login.php?mensaje=$mensaje");
        die;
    }
    $usuario=checkuser($email,$password);
    if ($usuario==null) {
        $mensaje="ERROR:Credenciales invalidas...";
        header("Location: login.php?mensaje=$mensaje");
        die;
    } else {
        $mensaje="Login Correcto";
        header("Location: login.php?mensaje=$mensaje");
        die;
    }
    
}
?>