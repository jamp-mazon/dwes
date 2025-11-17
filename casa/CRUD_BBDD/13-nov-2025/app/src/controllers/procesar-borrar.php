<?php 
session_start();
require __DIR__."/../../vendor/autoload.php";
use App\models\Basedatos;
if ($_SERVER["REQUEST_METHOD"]!=="POST") {
    header("Location:../views/listado.php");
    exit;
}
else{
    $id=$_POST["id"]??null;
    $mibd=new Basedatos();

    $mibd->borrar_tarea($id);
    header("Location:../views/listado.php");
    exit();
}

?>