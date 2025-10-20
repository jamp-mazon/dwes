<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilos.css">
    <title>FABULARIA</title>
</head>

<body>
    <header>
        <?php
        include("header.php");
        ?>
    </header>
    <main>
        <form class="formulario" action="procesar_alta.php" method="POST" enctype="multipart/form-data"> <!--Importante si no no coge el array de la imagen -->

            <label for="titulo">Titulo</label>
            <input type="text" id="titulo" name="titulo" required><br>

            <label for="autor">Autor</label>
            <input type="text" id="autor" name="autor" required><br>

            <label for="anio">Año de Publicacion</label>
            <input type="number" id="anio" name="anio">

            <label for="genero">Generos:</label><br>
            <input type="checkbox" name="generos[]" value="romance">Romance
            <input type="checkbox" name="generos[]" value="ciencia-ficcion">Ciencia Ficcion
            <input type="checkbox" name="generos[]" value="policiaco">Policiaco <br>
            <input type="checkbox" name="generos[]" value="terror">Terror
            <input type="checkbox" name="generos[]" value="historico">Historico
            <input type="checkbox" name="generos[]" value="Fantasia">Fantasia <br>
            <hr>
            <legend>Subida de Caratula</legend>
            <p>Tamaño maximo de 1 MB
                <input type="file" name="caratula">
            </p>
            <p><button type="submit" name="submit" value="subirimagen">Guardar libro</button></p>


        </form>
    </main>
    <footer>
        <?php
        include("footer.php");
        ?>
    </footer>
</body>

</html>