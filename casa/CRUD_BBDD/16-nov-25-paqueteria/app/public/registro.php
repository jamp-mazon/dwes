<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro - TODO</title>
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
        .register-container {
            background: #ffffff;
            padding: 2rem;
            border-radius: .75rem;
            box-shadow: 0 4px 10px rgba(0,0,0,.1);
            width: 100%;
            max-width: 420px;
        }
        .register-container h1 {
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
        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: .6rem .8rem;
            border-radius: .4rem;
            border: 1px solid #ccc;
        }
        input:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 1px rgba(37,99,235,.3);
        }
        .btn {
            width: 100%;
            padding: .7rem;
            border: none;
            border-radius: .4rem;
            background: #16a34a;
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

<div class="register-container">
    <h1>Crear cuenta</h1>

    <!-- Cambia action="procesar_registro.php" por tu script de registro -->
    <form action="../src/Controllers/procesar-registro.php" method="POST">
        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input
                type="text"
                id="nombre"
                name="nombre"
                required
                placeholder="Tu nombre"
                value="<?= isset($_SESSION["nombre"])? $_SESSION["nombre"]:"" ?>"
            >
        </div>

        <div class="form-group">
            <label for="email">Correo electrónico</label>
            <input
                type="email"
                id="email"
                name="email"
                required
                autocomplete="email"
                placeholder="tucorreo@ejemplo.com"
                value="<?= isset($_SESSION["email"])? $_SESSION["email"]:"" ?>"

            >
        </div>

        <div class="form-group">
            <label for="password">Contraseña</label>
            <input
                type="password"
                id="password"
                name="password"
                required
                autocomplete="new-password"
                placeholder="Mínimo 8 caracteres"
            >
        </div>

        <div class="form-group">
            <label for="password2">Repite la contraseña</label>
            <input
                type="password"
                id="password2"
                name="password2"
                required
                autocomplete="new-password"
                placeholder="Repite la contraseña"
            >
        </div>

        <button type="submit" class="btn">Registrarme</button>

        <div class="extra">
            ¿Ya tienes cuenta? <a href="index.php">Inicia sesión</a>
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