<?php

require_once "funciones.php";

$conexion = conectaDb();

$nombre="Pepito";
$apellidos="Conejo";
$edad=69;
try {
    $consulta="INSERT INTO personas(nombre,apellidos,edad) VALUES (:valor1,:valor2,:valor3)";
    $sentencia=$conexion->prepare($consulta);
    $sentencia->BindParam(":valor1",$nombre);
    $sentencia->BindParam(":valor2",$apellidos);
    $sentencia->BindParam(":valor3",$edad);
    $sentencia->execute();
    echo "<p>Registro creado correctamente</p>";


} catch (PDOException $e) {
    echo $e->getMessage();
    die;
}


?>