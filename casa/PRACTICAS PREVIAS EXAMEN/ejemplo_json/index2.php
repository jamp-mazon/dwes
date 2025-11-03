<?php 
session_start();
$json=file_get_contents("peliculas.json",FILE_USE_INCLUDE_PATH);
$lista_peliculas=json_decode($json);//cojo las pelis del json

if (isset($_POST["cambiar_idioma"])) { //si existe el post
    if (!isset($_COOKIE["idioma"])||$_COOKIE["idioma"]=="es") {//si no existe cookie idioma o la cookie es en español
        setcookie("idioma","uk",time()+3600,"/");//me la creo en ingles
    }
    else{
        setcookie("idioma","es",time()+3600,"/");//si no en español
    }
    header("Location:".$_SERVER["PHP_SELF"]);//redireccionas en la misma pag

    
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
    <?php foreach ($lista_peliculas as $pelicula): ?>
        <h2><?=$pelicula->titulo->$idioma ?></h2>
        <p><strong>Año:</strong><?=$pelicula->ano?></p>
        <p><strong>Género:</strong><?=$pelicula->genero ?></p>
        <p><strong>Director:</strong><?=$pelicula->director->nombre?></p>
    <?php endforeach; ?>
    <form method="POST" action="">
        <button type="submit" name="cambiar_idioma">
            Cambiar idioma (actual: <?php echo strtoupper($idioma); ?>)
        </button>
    </form>

</body>
</html>