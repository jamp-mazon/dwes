<?php 
session_start();
require __DIR__ . "/../vendor/autoload.php";
use App\Models\Basedatos;


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - TODO</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * {
            box-sizing: border-box;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }
        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #f5f5f5;
        }
        .login-container {
            background: #ffffff;
            padding: 2rem;
            border-radius: .75rem;
            box-shadow: 0 4px 10px rgba(0,0,0,.1);
            width: 100%;
            max-width: 400px;
        }
        .login-container h1 {
            margin-top: 0;
            margin-bottom: 1.5rem;
            text-align: center;
        }
        .form-group {
            margin-bottom: 1rem;
        }
        label {
            display: block;
            margin-bottom: .35rem;
            font-weight: 600;
        }
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: .6rem .8rem;
            border-radius: .4rem;
            border: 1px solid #ccc;
        }
        input[type="email"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 1px rgba(37,99,235,.3);
        }
        .btn {
            width: 100%;
            padding: .7rem;
            border: none;
            border-radius: .4rem;
            background: #2563eb;
            color: white;
            font-weight: 600;
            cursor: pointer;
        }
        .btn:hover {
            filter: brightness(1.05);
        }
        .extra {
            margin-top: .8rem;
            text-align: center;
            font-size: .9rem;
        }
        .error{
            color: darkred;
            margin-top: .8rem;
            font-size: .9rem;
        }        
        .extra a {
            color: #2563eb;
            text-decoration: none;
        }
        .extra a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="login-container">
    <h1>Iniciar sesión</h1>

    <!-- Cambia action="login.php" por la ruta donde proceses el login -->
    <form action="../src/Controllers/procesar-login.php" method="POST">
        <div class="form-group">
            <label for="email">Correo electrónico</label>
            <input
                type="email"
                id="email"
                name="email"
                required
                autocomplete="email"
                placeholder="tucorreo@ejemplo.com"
            >
        </div>

        <div class="form-group">
            <label for="password">Contraseña</label>
            <input
                type="password"
                id="password"
                name="password"
                required
                autocomplete="current-password"
                placeholder="Tu contraseña"
            >
        </div>

        <button type="submit" class="btn">Entrar</button>

        <div class="extra">
            <!-- Por si luego haces registro -->
            ¿No tienes cuenta? <a href="registro.php">Regístrate</a>
        </div>
        <?php if (isset($_SESSION["errores"])): ?>
        <div class="error">
            <?php for ($i=0; $i < count($_SESSION["errores"]); $i++): ?>
            <p><?= $_SESSION["errores"][$i] ?></p>
            <?php endfor; ?>
        </div>
        <?php endif; ?>
        <?php unset ($_SESSION["errores"]); ?>
    </form>
</div>

</body>
</html>
