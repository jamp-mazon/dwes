<?php
session_start();
include_once "funciones/utilidades.php";
if ($_SERVER["REQUEST_METHOD"]!="POST"){
    header("Location:cartelera.php");
    die;
}
else{
    $_SESSION["errores"]=[];
    $_SESSION["mensajes"]=[];
    $titulo=$_POST["titulo"]?? "";
    if (is_null($titulo)) {
        $_SESSION["errores"][]="Titulo invalido...";
        header("Location:cartelera.php");
        die;
    }
    else{
        if (borrarPelicula($titulo)) {
            $_SESSION["mensajes"][]="Pelicula borrada con exito!!";
            header("Location:cartelera.php");
            die;
        }
        else{
            $_SESSION["errores"][]="La pelicula no se pudo borrar";
            header("Location:cartelera.php");
        }
    }
}

?>