<?php

require_once "funciones.php";

$conexion = conectaDb();

try {
    $consulta="DELETE FROM personas where nombre=:nombre and apellidos =:apellidos";

    

} catch (PDOException $e) {
    echo $e->getMessage();
    die;
}
?>