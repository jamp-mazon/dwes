<?php
session_start();
require __DIR__. "/../../vendor/autoload.php";
use App\models\Basedatos;

if (isset($_GET["id"])) {
    $id_incidencia=$_GET["id"];
    $mibd=new Basedatos();
    $sql="SELECT * FROM incidencias where id=:id";
    $parametro=[":id"=>$id_incidencia];
    $sentencia=$mibd->get_data($sql,$parametro);
    $registroPDO=$sentencia->fetch(PDO::FETCH_OBJ);
    $resolver_incidencia=$registroPDO->resuelta;
    if ($resolver_incidencia==0) {
        $resolver_incidencia=1;
    }
    else{
        $resolver_incidencia=0;
    }
    $parametros=[":resolver_incidencia"=>$resolver_incidencia, ":id"=>$id_incidencia];
    $update="UPDATE incidencias SET resuelta=:resolver_incidencia where id=:id";
    $sentencia2=$mibd->get_data($update,$parametros);
    if ($sentencia2==null) {
        $log=milog("Error al realizar el update",false);  
    }
    header("Location:listado.php");
    die;
}
else{
    $log=milog("ERROR no entras por el get",false);
    header("Location:listado.php");
    die;
}
?>