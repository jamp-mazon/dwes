<?php
require_once "../app/models/baseDatos.php";

$dbInstancia=BaseDatos::getInstance();

if ($dbInstancia!=null) {
    echo "Conexion realizada con exito!!!";
    header("Location:../app/views/listado_libros.php");
} else {
    echo "F...CONEXION FALLIDA... SIGUE INTENTANDOLO!!";
}


?>
