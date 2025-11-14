<?php
require __DIR__. "/../../vendor/autoload.php";
use App\models\Basedatos;
use App\models\Tarea;

if ($_SERVER["REQUEST_METHOD"]!=="POST") {
    header("Location:../../public/index.php");
    die;
}
else{
    $id=$_POST["id"];
    $mibd=new Basedatos();
    // $array=[":id"=>$id];
    // $sql="SELECT * FROM tareas WHERE :id";
    // $sentencia=$mibd->get_data($sql,$array);

    // $registro=$sentencia->fetch(PDO::FETCH_OBJ);
    // $tarea=new Tarea($registro->id,$registro->descripcion,$registro->completada);

    $mibd->borrar_tarea($id);

    header("Location:../views/listado.php");
    exit;

}


?>