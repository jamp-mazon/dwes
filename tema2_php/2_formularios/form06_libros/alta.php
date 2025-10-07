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
        <form action="procesar_alta.php" method="POST">
            <label for="titulo">Titulo</label>
            <input type="text" id="titulo" name="titulo" required>
            

        </form>
    </main>
    <footer>
        <?php
            include("footer.php");
        ?>
    </footer>
</body>
</html>