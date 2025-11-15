<?php 
require __DIR__."/../vendor/autoload.php";
use App\models\Basedatos;
$miBD=new Basedatos();

if ($miBD->estaConectado()) {
    header("Location:../src/views/listado.php");
}
else{
    $mensaje="Error:en la conexion";
}


?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>ToDO</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <?= $mensaje ?> 
</body>
</html>