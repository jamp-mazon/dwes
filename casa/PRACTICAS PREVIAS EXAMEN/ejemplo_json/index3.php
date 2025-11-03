<?php 
$peliculas=[];
$json=file_get_contents("peliculas.json",FILE_USE_INCLUDE_PATH);
$peliculas=json_decode($json);

if (isset($_POST["cambiar_idioma"])) {
    if (!isset($_COOKIE["idioma"]) || $_COOKIE["idioma"]==="es") {
        setcookie("idioma","uk",time()+3600,"/");
    }
    else{
        setcookie("idioma","es",time()+3600,"/");
    }

}
if (isset($_COOKIE["idioma"])) {
    $idioma=$_COOKIE["idioma"];
}
else{
    $idioma="es";
}


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Película seleccionada</title>
</head>
<body>
    <?php foreach ($peliculas as $pelicula): ?>
        <h2><?=$pelicula->titulo->$idioma?></h2>
        <p><strong>Año:</strong><?=$pelicula->ano?></p>
        <p><strong>Género:</strong><?=$pelicula->genero ?></p>
        <p><strong>Director:</strong><?=$pelicula->director->nombre?>(Nacionalidad:<?=$pelicula->director->nacionalidad?>)</p>
    <?php endforeach; ?>
    <form method="POST">
        <button type="submit" name="cambiar_idioma">
            Cambiar idioma (actual: <?php echo strtoupper($idioma); ?>)
        </button>
    </form>

</body>
</html>