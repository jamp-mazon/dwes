<?php

require_once "funciones.php";

$conexion = conectaDb();

try {
    $consulta="DELETE FROM personas "

} catch (PDOException $e) {
    echo $e->getMessage();
    die;
}
?>