<?php
$comic=[];
$json=file_get_contents("imagenes.json",FILE_USE_INCLUDE_PATH);
$comic=json_decode($json);
if (isset($_COOKIE["paginaActual"])) {
    $pagina=$_COOKIE["paginaActual"];
}
else{
    $pagina=0;
}
if (isset($_POST["boton"])) {
    if ($_POST["boton"]==="anterior") {
        if ($pagina<=0) {
            $pagina=0;
        }
        else{
            --$pagina;
        }
    }
    if ($_POST["boton"]==="siguiente") {
        if ($pagina>=3) {
            $pagina=3;
        }
        else{
            ++$pagina;
        }
    }
}

setcookie("paginaActual",$pagina,time()+3600,"/");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cómic</title>
</head>
<body>

<img src="<?= $comic[$pagina]->imagen ?>" alt="imagen">

<form method="POST">
    <button type="submit" name="boton" value="anterior" <?= $pagina == 0 ? "disabled" : "" ?>>Anterior</button>
    <button type="submit" name="boton" value="siguiente"<?= $pagina == 2 ? "disabled" : "" ?>>Siguiente</button>
</form>

</body>
</html>