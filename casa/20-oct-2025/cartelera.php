<?php
session_start();
include_once "funciones/utilidades.php";
// print("<pre>");
// print_r($_SESSION);
// print("</pre>");  
// print("<hr>");
// print("<pre>");
// print_r($_SESSION["usuario"]->email);
// print("</pre>");
$lista_peliculas = obtener_peliculas();
$ruta_imagen = "assets/images/imagenes_peliculas/";
unset($_SESSION["mensajes"]);

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
            <!-- <?php if ($_SESSION["usuario"]->esAdmin): ?> -->
            <a href="admin_cartelera.php" class="btn">Administrar cartelera</a>
            <!-- <?php endif; ?> -->
            <a href="logOut.php" class="btn-sec">Salir</a>
        </nav>
    </header>

    <main class="container grid">
        <!-- Aquí iterarás con PHP tu JSON de películas: foreach { … } -->
        <?php foreach ($lista_peliculas as $pelicula): ?>
            <!-- Tarjeta de ejemplo (duplicar con foreach) -->
            <article class="movie-card">
                <div class="movie-img">
                    <img src="<?= $ruta_imagen . $pelicula->poster ?>" alt="Título de la película">
                </div>
                <div class="movie-body">
                    <h2 class="movie-title"><?= $pelicula->titulo ?></h2>
                    <p class="movie-meta">
                        <span><?= $pelicula->categoria ?></span>
                        <span><?= $pelicula->duracion ?>min</span>
                    </p>
                    <p class="movie-desc">
                        <?= $pelicula->sinopsis ?>
                    </p>
                    <div class="movie-actions ">
                        <a class="btn" href="butaca.php">Acceder</a>
                        <a class="btn" href="procesar_info.php?titulo=<?= $pelicula->titulo ?>">Mas info</a>
                        <!-- COMIENZO DE BOTON CON ADMIN -->
                        <?php if (isset($_SESSION['usuario']) && isset($_SESSION['usuario']->esAdmin) && $_SESSION['usuario']->esAdmin): ?>
                            <form action="procesar_borrar.php" method="post">
                                <input type="hidden" name="titulo" value="<?= $pelicula->titulo ?>">
                                <button style="cursor: pointer; border-radius:15px; border:none; width:100px; height:40px;margin-top: 10px;margin-left:10px; background-color: #b81414;color:antiquewhite" type="submit">Borrar</button>
                            </form>
                            <!-- FIN DE BOTON ADMIN  -->
                        <?php endif; ?>
                    </div>
                </div>
            </article>
            <div style="display: block;">
                <!-- COMIENZO DE ERRORES -->
                <?php if (!empty($_SESSION["errores"])): ?>
                    <?php foreach ($_SESSION["errores"] as $error): ?>
                        <p><?= $error ?></p>
                    <?php endforeach; ?>
                <?php endif; ?>
                <!-- FIN DE ERRORES -->
                <!-- COMIENZO MENSAJES -->
                <?php if (!empty($_SESSION["mensajes"])): ?>
                    <?php foreach ($_SESSION["mensajes"] as $mensaje): ?>
                        <p><?= $mensaje ?></p>
                    <?php endforeach; ?>
                    <!-- FIN MENSAJES -->
                <?php endif; ?>
            </div>
        <?php endforeach; 
            unset($_SESSION["errores"]);
            unset($_SESSION["mensajes"]);
        ?>

        <!-- /fin ejemplo -->
    </main>
</body>

</html>