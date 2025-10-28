<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login con Cookies y Sesiones</title>
</head>
<body>
    <h2>Iniciar sesión</h2>
    <form method="post" action="procesar-login.php">
        <label>Usuario:</label>
        <input type="text" name="usuario" value="<?php $_COOKIE=$_COOKIE["usuario"]?? ""?>" required><br><br>

        <label>Contraseña:</label>
        <input type="password" name="clave" required><br><br>

        <label>
            <input type="checkbox" name="recordar">
            Recordarme
        </label><br><br>

        <button type="submit">Entrar</button>
    </form>
    <?php
        if (!empty($_SESSION["errores"])) {
            foreach ($_SESSION["errores"] as $error) {
               echo "<p style='color: red;'>$error</p>";
            }
        }
        unset($_SESSION["errores"]);
    ?>
</body>
</html>