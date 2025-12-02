<?php
require __DIR__ . "/vendor/autoload.php";
use App\models\Basedatos;

$mibd=new Basedatos();
$mensaje="";
if ($mibd->getConexionPDO()!==null) {
    header("Location:src/views/login.php");
}
else{
    $mensaje="Error al conectarse a la base de datos";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestor Incidencias</title>
    <link rel="stylesheet" href="public/css/estilos.css">
</head>
<body class="centrado">
    <h2><?= $mensaje ?></h2> 
    <div>
    <!-- boton para generar la bbdd -->
    </div> 
</body>
</html>
