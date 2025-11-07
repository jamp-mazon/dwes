<?php
require_once "../models/basedatos.php";

if ($_SERVER["REQUEST_METHOD"!=="POST"]) {
    header("Location:../views/listado.php");
    die;
}
else{
    $id=$_POST["id_a_borrar"]??"";
    if (empty($id)) {
        header("Location:../views/listado.php");
        die;
    }
    else{
        $dbInstancia=BaseDatos::getInstance();
        $dbInstancia->borrar_usuario($id);
        header("Location:../views/listado.php");
        die;
    }
}

?>