<?php 
session_start();
require __DIR__."/../../vendor/autoload.php";
use App\models\Basedatos;
use App\models\Tarea;

if ($_SERVER["REQUEST_METHOD"!=="POST"]) {
    header("Location:../views/listado.php");
    die;
}
else{
    
    $mibd=new Basedatos();
    $miTarea=new Tarea(null,$_POST["descripcion"],false);
    $mibd->crear_tarea($miTarea);
    header("Location:../views/listado.php");
    exit;
}

?>