<?php
session_start();
include_once "funciones/utilidades.php";
$titulo=$_GET["titulo"];
$pelicula=devolverPelicula($titulo);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body class="bg">
    <header class="hdr">
        <h1><?=$titulo?></h1>
    </header>
    <main class="">
        <div class="contenedor-externo">
            <div class="contenedor-poster">
            <img src="assets/images/imagenes_peliculas/<?=$pelicula->poster?>" 
            alt="Origen"
            width="400px"
            height="500px">
            </div>
            <div class="contenedor-info">
            <h1>Titulo:<?=$pelicula->titulo?></h1>
            <p>Duracion:<?=$pelicula->duracion ?></p>
            <p>Sinopsis:<?=$pelicula->sinopsis?></p>
            <a href="cartelera.php"> 
            <button class="btn">Volver</button></a>    
            </div>
           
        </div>
        
    </main>
</body>
</html>