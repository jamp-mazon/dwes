<?php 
require __DIR__. "/../../vendor/autoload.php";
use App\models\Basedatos;
use App\models\Tarea;

if ($_SERVER["REQUEST_METHOD"]!=="POST") {
    header("Location:../../public/index.php");
    die;
}
else{
    $descripcion=$_POST["descripcion"]??"";
    $mibd=new Basedatos();
    $tarea=new Tarea(null,$descripcion);
    $mibd->crear_tarea($tarea);
    header("Location:../views/listado.php");
    die;
}

?>