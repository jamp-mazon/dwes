<?php
session_start();
if (!isset($_SESSION["numero"])) {
    $_SESSION["numero"]=0;
    $numero=$_SESSION["numero"];
}
else{
    $numero=$_SESSION["numero"];
}
if (!isset($_COOKIE["pulsaciones"])) {
    setcookie("pulsaciones",0,time()+(7*24*60*60),"/");
   
}
$pulsaciones=$_COOKIE["pulsaciones"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>02_Subir y Bajar numero</h2>
    <p>Haga click en los botones para modificar el valor:</p>
    <form action="procesar_boton.php" method="POST">
    <button type="submit" name="boton" value="bajar">-</button>
    <p>
        <?php
            echo "<span style='font-size: 4rem'>$numero</span>";
        ?>
    </p>
    <?php
    echo "<h3>Pulsaciones en total:$pulsaciones</h3>";
    ?>

    <button type="submit" name="boton" value="subir">+</button>
    <button type="submit" name="boton" value="cero">Poner a cero</button>
    </form>
</body>
</html>