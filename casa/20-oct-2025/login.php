<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CINE · Login</title>
    <link rel="stylesheet" href="estilos.css">
</head>

<body class="bg">
    <header class="hdr">
        <h1>CINE · Login</h1>
        <nav><a class="btn-sec" href="index.php">Crear cuenta</a></nav>
    </header>

    <main class="container">
        <form class="card" action="procesar_login.php" method="post">
            <h2>Iniciar sesión</h2>

            <label>Email
                <input type="email" name="email" placeholder="tucorreo@ejemplo.com" value="<?php echo ($_COOKIE["email"])?? "" ?>">
            </label>

            <label>Contraseña
                <input type="password" name="password" placeholder="••••••••">
            </label>
            <label class="remember">
                <input type="checkbox" name="recordar" value="1">
                Recuérdame
            </label>

            <div class="alert" hidden>
                <p>• Aquí aparecerán los errores de login.</p>
            </div>

            <button type="submit" class="btn">Entrar</button>
        </form>
    </main>
</body>

</html>