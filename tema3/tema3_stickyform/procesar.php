<?php
session_start();
require_once "includes/funciones.php";
if ($_SERVER["REQUEST_METHOD"]!="POST") {
    header("Location:index.html");
    die;
}
else{
    //Venimos del formulario
    $nombre=recoge("nombre");
    $edad=recoge("edad");
    $OK=true;
    //Tratar el nombre
    if (is_null($nombre)) {
        $OK=false;
       // $_SESSION["error_nombre"]="Falta el nombre";
        $_SESSION["error"]["nombre"]="Falta el nombre";
    }
    else{
        $_SESSION['nombre']=$nombre;
    }
    if (is_null($edad)) {
        $OK=false;
        $_SESSION["error"]["edad"]="Falta la edad";
    }
    elseif (!is_numeric($edad)) {
        $_SESSION["error"]["edad"]="Edad debe ser un numero";
        $OK=false;
    }
    elseif ($edad<1) {
        $_SESSION["error"]["edad"]="Edad debe ser positivo";
        $OK=false;
    }
    else{
        $_SESSION["edad"]=$edad;
    }
    //si todo es ok entro en mostrar datos , si no vuelvo al index
    if ($OK) {
        header("Location:mostrar_datos.php");
        die;
    }
    else{
        header("Location:index.php");
        die;
    }
    
}

?>