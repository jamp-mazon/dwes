<?php 
session_start();
if (!isset($_SESSION["form2"])|| $_SESSION["form2"]!=true) {
  header("Location:formulario1.php");
  die;
}
$nombre=$_SESSION["nombre"]??"";
$curso=$_SESSION["curso"]??"";
if (isset($_SESSION["daw1"])) {
    $lista_daw=$_SESSION["daw1"];
}elseif (isset($_SESSION["daw2"])) {
    $lista_daw=$_SESSION["daw2"];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Datos Matricula</title>
</head>
<body>
    <h1>FORMULARIO DE MATRICULA</h1>

    <h2>Datos finales de la matricula</h2>
    <p>Nombre:<?=$nombre?></p>
    <p>Curso:<?=$curso?></p>
    <ul>
        Lista de Materias:
        <?php foreach ($lista_daw as $asignatura):?>
            <li><?=$asignatura?></li>
        <?php endforeach; ?>    
    </ul>
    <a href="formulario1.php"><button>Volver al formulario index</button></a>
</body>
</html>