<?php 
session_start();
require __DIR__."/../../vendor/autoload.php";
use Mpdf\Mpdf;
use App\models\Basedatos;

if ($_SERVER["REQUEST_METHOD"]!=="POST") {
    header("Location:../views/listado.php");
    exit;
}
else{
    if (isset($_POST["pdf"])) {
        $mipdf=new Mpdf();
        $mibd=new Basedatos();
        $mipdf->WriteHTML("<h1>LISTA DE TAREAS</h1>");
        $id=$_POST["id"];
        $parametros=[":usuario_id"=>$id];
        $sql = "SELECT tareas.id AS tarea_id,
               tareas.usuario_id,
               tareas.descripcion,
               tareas.completada
               FROM tareas
               WHERE tareas.usuario_id = :usuario_id";
        $sentencia=$mibd->get_data($sql,$parametros);


        while ($registroPDO=$sentencia->fetch(PDO::FETCH_OBJ)){
            $mipdf->WriteHTML("<p>$registroPDO->descripcion</p>");
        }
        
        // $registrosPDO=$sentencia->fetchAll(PDO::FETCH_OBJ);
        // foreach ($registrosPDO as $registro) {
        //     $mipdf->WriteHTML("<p>$registro->descripcion</p>");            
        // }
        $mipdf->WriteHTML("<h2>FIN</h2>");
        $mipdf->Output();
    }
}
?>