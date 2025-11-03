<?php
// 1. Leer el archivo JSON y convertirlo en objetos (sin 'true')
$json = file_get_contents("peliculas.json");
$peliculas = json_decode($json);

// 2. Escogemos una película (por ejemplo la segunda)
$peli = $peliculas[1];

// 3. Si se ha pulsado el botón de cambiar idioma
if (isset($_POST['cambiar_idioma'])) {

    // Si no existe la cookie o está en español, la cambiamos a inglés
    if (!isset($_COOKIE['idioma']) || $_COOKIE['idioma'] == 'es') {
        setcookie("idioma", "uk", time() + 3600, "/");
    } 
    // Si está en inglés, la cambiamos a español
    else {
        setcookie("idioma", "es", time() + 3600, "/");
    }

    // Recargamos la página para aplicar el cambio
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// 4. Si ya hay cookie, usamos ese idioma; si no, español
if (isset($_COOKIE['idioma'])) {
    $idioma = $_COOKIE['idioma'];
} else {
    $idioma = "es";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Película seleccionada</title>
</head>
<body>

    <h2><?php echo $peli->titulo->$idioma; ?></h2>
    <p><strong>Año:</strong> <?php echo $peli->ano; ?></p>
    <p><strong>Género:</strong> <?php echo $peli->genero; ?></p>
    <p><strong>Director:</strong> <?php echo $peli->director->nombre; ?> (<?php echo $peli->director->nacionalidad; ?>)</p>

    <form method="POST">
        <button type="submit" name="cambiar_idioma">
            Cambiar idioma (actual: <?php echo strtoupper($idioma); ?>)
        </button>
    </form>

</body>
</html>