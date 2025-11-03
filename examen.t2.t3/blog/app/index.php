<?php 
session_start();
require_once "includes/funciones.php";
$lista_articulos=obtenerDatos();
if ($_SERVER["REQUEST_METHOD"]=="POST") {
        if ($_POST["boton"]==="es") {
            $idioma=$_POST["boton"];
            $_SESSION["idioma"]=$idioma;
        }elseif ($_POST["boton"]==="uk") {
            $idioma=$_POST["boton"];
            $_SESSION["idioma"]=$idioma;
        }
}
else{
    if (isset($_SESSION["idioma"])) {
        $idioma=$_SESSION["idioma"];
    }
    else{
        $idioma="es";//si no vengo del post en español
        $_SESSION["idioma"]=$idioma;
    }
}
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
    <div class="selector-idioma">
        <form action="<?php $_SERVER["PHP_SELF"] ?>" method="post">
        <button class="boton-idioma" name="boton" value="es"><img src="img/spain.png" width="50px"></button> 
        <button class="boton-idioma" name="boton" value="uk"><img src="img/uk.png" width="50px"></button> 
        </form>
    </div>

    <main>
        <ul>
        <?php foreach ($lista_articulos as $articulo): ?>
            <li><a href="articulo.php?id=<?=$articulo->id?>"><h3><?=$articulo->title->$idioma ?></h3></a></li>
            <?php $_SESSION["articulo"]=$articulo; ?>
        <?php endforeach; ?>    
        
        </ul> 
    </main>

<footer>
    <?php include_once "footer.php"; ?>  
</footer>  
</body>
</html>