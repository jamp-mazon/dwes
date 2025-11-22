<?php
session_start();
require __DIR__ ."/../../vendor/autoload.php";
use Mpdf\Mpdf;
use App\models\Basedatos;

$mipdf=new Mpdf();
$mibd=new Basedatos();
$sql="SELECT * FROM incidencias";
$sentencia=$mibd->get_data($sql);
$mipdf->WriteHTML("<h1>Lista de incidencias</h1>");
while ($registro=$sentencia->fetch(PDO::FETCH_OBJ)) {
    $mipdf->WriteHTML("<h4>$registro->titulo </h4>");
    $mipdf->WriteHTML("<p>$registro->descripcion</p>");
    $mipdf->WriteHTML("<hr>");
    
}
$mipdf->Output();


?>