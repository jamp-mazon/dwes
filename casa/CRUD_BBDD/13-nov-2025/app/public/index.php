<?php 
require __DIR__."/../vendor/autoload.php";
use App\models\Basedatos;
$miBD=new Basedatos();
$mensaje="";

if ($miBD->estaConectado()) {
    //header("Location:../src/views/listado.php");

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
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <h1>TAREAS CON USUARIOS</h1>
    <div class="formularios">
        
        <form class="form-registro"  action="../src/controllers/procesar-registro.php" method="post">
            <h3>REGISTRAR USUARIO</h3>
            <label for="user">Usuario:</label>
            <input type="text" name="user">
            <label for="email">Email:</label>
            <input type="email" name="email">
            <label for="password1">Contraseña:</label>
            <input type="password" name="password1">
            
            <label for="password2">Repite Contraseña:</label>
            <input type="password" name="password2"><br>
            <button type="submit">Enviar</button><br>
        </form>
        <a href="login.php"><button>YA ESTOY REGISTRADO</button></a>
    </div>
    <?= $mensaje ?> 
</body>
</html>