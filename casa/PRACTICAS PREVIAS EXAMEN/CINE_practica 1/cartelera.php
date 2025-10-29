<?php 
session_start();
$_SESSION["login"]=$_SESSION["login"]??header("Location:login.php");
$esAdmin=$_SESSION["esAdmin"]??false;

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CINE · Cartelera</title>
    <link rel="stylesheet" href="estilos.css">
</head>

<body class="bg">
    <header class="hdr">
        <h1>Cartelera</h1>
        <nav>
            <a href="index.php" class="btn-sec">Inicio</a>
            <!-- <?php if ($esAdmin): ?> -->
            <a href="admin_cartelera.php" class="btn">Administrar cartelera</a>
            <!-- <?php endif; ?> -->
            <a href="logOut.php" class="btn-sec">Salir</a>
        </nav>
    </header>

    <main class="container grid">
        <!-- Aquí iterarás con PHP tu JSON de películas: foreach { … } -->
        <!-- Tarjeta de ejemplo (duplicar con foreach) -->
        <article class="movie-card">
            <div class="movie-img">
                <img src="https://placehold.co/600x900" alt="Título de la película">
            </div>
            <div class="movie-body">
                <h2 class="movie-title">Título de la película</h2>
                <p class="movie-meta">
                    <span>2024</span> ·
                    <span>Ciencia ficción</span> ·
                    <span>120 min</span>
                </p>
                <p class="movie-desc">
                    Sinopsis breve de la película para mostrar una descripción corta.
                </p>
                <div class="movie-actions">
                    <a class="btn" href="butacas.php">Acceder</a>
                    <a class="btn" href="masInfo.php">INFO</a>
                    <?php if ($esAdmin): ?>
                    <a class="btn" href="borrar.php">Borrar</a>
                    <?php endif; ?>
                </div>
            </div>
        </article>
        <!-- /fin ejemplo -->
    </main>
</body>

</html>