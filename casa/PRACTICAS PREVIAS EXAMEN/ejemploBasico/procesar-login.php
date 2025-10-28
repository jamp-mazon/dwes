<?php
session_start();
$usuario_valido = "admin";
$clave_valida = "1234";
if ($_SESSION["usuario"]) {
    header("Location:bienvenida.php");
    die;
}

if ($_SERVER["REQUEST_METHOD"]!=="POST") {
    $_SESSION["errores"]=$_SESSION["errores"]?? [];
    $_SESSION["errores"][]="Primero hay que logearse...";
    header("Location:index.php");
    die;
}
else{
    $usuario=$_POST["usuario"]?? "";
    $clave=$_POST["clave"] ?? "";
    $_SESSION["errores"]=$_SESSION["errores"]?? [];
    if (empty($usuario)) {
        $_SESSION["errores"][]="El campo del usuario es obligatorio...";
        header("Location:index.php");
        die;    
    }
    else{
        $usuario=trim(htmlspecialchars(strip_tags($usuario)));
        $recordar=$_POST["recordar"]?? "";
        if (!empty($recordar)) {
            setcookie("usuario",$usuario,time()+ (7 * 24 * 60 * 60), "/");
        }
        else{
            setcookie("usuario",$usuario,time()-86400,"/");
        }
        $usuarioOK= ($usuario===$usuario_valido) ? true:false;
        if (!$usuarioOK) {
            $_SESSION["errores"][]="El usuario no coincide...";
            header("Location:index.php");
            die;
        }
     
    }
    if (empty($clave)) {
        $_SESSION["errores"][]="La clave es obligatoria...";
        header("Location:index.php");
        die;
    }
    else{
        $clave=trim($clave);
        $claveOK=($clave===$clave_valida)? true:false;
        if (!$claveOK) {
            $_SESSION["errores"][]="La contraseña no coincide...";
            header("Location:index.php");
            die;
        }
        if ($usuarioOK && $claveOK) {
            $_SESSION["login"]=true;
            $_SESSION["usuario"]=$usuario;
            header("Location:bienvenida.php");
        }
    }
}
?>