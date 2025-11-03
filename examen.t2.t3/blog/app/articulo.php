<?php 
session_start();
require_once "includes/funciones.php";
$idioma=$_SESSION["idioma"]??"es";
if (isset($_GET["id"])) {
    $id=$_GET["id"]??"";
    $articulo=obtenerArticulo($id);
}

$articulo=obtenerArticulo($id);


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/styles.css">
    <title>BLOG</title>
</head>
<header>
    <?php include_once "header.php"; ?>
</header>
<body>
    
    <main>
        <?php if (is_null($articulo)):?>
            <p>Ese articulo no existe....</p>
        <?php endif; ?>    
        <?php if (!is_null($articulo)): ?>
        <article class="centrado">
            <a class="volver" href="index.php">VOLVER</a>
            <h3><?=$articulo->title->$idioma?></h3>
            <?=$articulo->description->$idioma?>
            <div><img src="<?=$articulo->image?>" width="300px"></div>
        </article>
        <?php endif; ?>
       
    </main>
<footer>
    <?php include_once "footer.php"; ?>  
</footer>  
</body>
</html>

