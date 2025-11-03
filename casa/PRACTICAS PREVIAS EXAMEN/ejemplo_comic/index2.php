<?php
// Cómic simulado
$comic = [
    "Página 1: ¡Inicio del cómic!",
    "Página 2: La aventura continúa...",
    "Página 3: ¡Clímax de la historia!",
    "Página 4: Desenlace final."
];

// Página actual
if (isset($_COOKIE['pagina_actual'])) {
    $pagina = $_COOKIE['pagina_actual'];
} else {
    $pagina = 0;
}

// Botones
if (isset($_POST['siguiente'])) {
    if ($pagina < 3) { // última página índice 3
        $pagina++;
    }
} elseif (isset($_POST['anterior'])) {
    if ($pagina > 0) {
        $pagina--;
    }
}

// Guardar página en cookie
setcookie('pagina_actual', $pagina, time() + 3600, "/");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cómic</title>
</head>
<body>

<h1><?= $comic[$pagina] ?></h1>

<form method="POST">
    <button type="submit" name="anterior" <?= $pagina == 0 ? "disabled" : "" ?>>Anterior</button>
    <button type="submit" name="siguiente" <?= $pagina == 3 ? "disabled" : "" ?>>Siguiente</button>
</form>

</body>
</html>