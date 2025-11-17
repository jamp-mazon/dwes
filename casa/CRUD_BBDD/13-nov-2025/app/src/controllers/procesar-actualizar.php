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
    $estado=$_POST["estado"]??null;
    $mibd=new Basedatos();

    $mibd->actualizar_tarea($id,$estado);

    header("Location:../views/listado.php");
    exit;
}

?>