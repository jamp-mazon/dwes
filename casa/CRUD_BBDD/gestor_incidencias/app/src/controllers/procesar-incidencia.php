<?php
session_start();

require __DIR__."/../../vendor/autoload.php";
use App\models\Basedatos;
use App\models\incidencias;

if ($_SERVER["REQUEST_METHOD"]!=="POST") {
    header("Location:../views/listado.php");
    $log=milog("Error no entrado por el post de Procesar-incidencia.php",false);
}
else{
    $id_usuario=$_SESSION["id"];
    $_SESSION["errores"]=[];
    $todoOK=true;
    $titulo=trim(htmlspecialchars(strip_tags($_POST["titulo"])))?? ($todoOK=false);
    $descripcion=trim(htmlspecialchars((strip_tags($_POST["descripcion"]))))?? ($todoOK=false);

    if (!$titulo) {
        $_SESSION["errores"][]="Error en el formato del titulo";
        $log=milog("Error:al añadir el titulo este tiene mal el formato",false);
        header("Location:../views/nueva-incidencia.php");
        die;
    }
    if (!$descripcion) {
        $_SESSION["errores"][]="Error en el formato de la descripcion";
        $log=milog("Error:al añadir la descripcion este tiene mal el formato",false);
        header("Location:../views/nueva-incidencia.php");
        die;
    }
    if ($todoOK) {
        $mibd=new Basedatos();
        $sql="INSERT INTO incidencias (titulo,descripcion,resuelta,id_usuario) VALUES (:titulo,:descripcion,:resuelta,:id_usuario)";
        $parametros=[":titulo"=>$titulo,":descripcion"=>$descripcion,":resuelta"=>false,":id_usuario"=>$id_usuario];
        $sentencia=$mibd->get_data($sql,$parametros);
        if ($sentencia==null) {
            $log=milog("Error la sentencia da null cuando se crea la incidencia",false);
            header("Location:../views/listado.php");
            die;
        }
        else{
            $log=milog("Exito al crear la nueva incidencia",true);
            header("Location:../views/listado.php");
            die;
        }
    }   
}

?>