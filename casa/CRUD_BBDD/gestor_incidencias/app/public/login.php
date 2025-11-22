<?php
session_start();
require __DIR__ ."/../vendor/autoload.php";


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar sesión - Gestor de Incidencias</title>
    <style>
        *{
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body{
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: radial-gradient(circle at top, #3b82f6 0, #020617 55%);
            color: #f9fafb;
        }
        .login-wrapper{
            width: 100%;
            max-width: 420px;
            padding: 2rem 1.5rem;
        }
        .login-card{
            background-color: rgba(15, 23, 42, 0.9);
            border-radius: 18px;
            padding: 2rem 2.2rem;
            box-shadow: 0 18px 45px rgba(0,0,0,0.55);
        }
        .login-header{
            text-align: center;
            margin-bottom: 1.5rem;
        }
        .login-header h1{
            font-size: 1.7rem;
            margin-bottom: 0.25rem;
        }
        .login-header p{
            font-size: 0.9rem;
            color: #9ca3af;
        }
        form{
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        .campo{
            display: flex;
            flex-direction: column;
            gap: 0.35rem;
        }
        label{
            font-size: 0.9rem;
            color: #e5e7eb;
        }
        input[type="email"],
        input[type="password"]{
            padding: 0.65rem 0.8rem;
            border-radius: 10px;
            border: 1px solid #4b5563;
            background-color: #020617;
            color: #f9fafb;
            font-size: 0.95rem;
            outline: none;
            transition: border-color 0.15s ease, box-shadow 0.15s ease, background-color 0.15s ease;
        }
        input[type="email"]::placeholder,
        input[type="password"]::placeholder{
            color: #6b7280;
        }
        input[type="email"]:focus,
        input[type="password"]:focus{
            border-color: #3b82f6;
            box-shadow: 0 0 0 1px #3b82f6;
            background-color: #020617;
        }
        .fila-opciones{
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.5rem;
            margin-top: 0.25rem;
        }
        .recordar{
            display: flex;
            align-items: center;
            gap: 0.35rem;
            font-size: 0.85rem;
            color: #9ca3af;
        }
        .recordar input[type="checkbox"]{
            accent-color: #3b82f6;
        }
        .enlace-olvido{
            font-size: 0.8rem;
        }
        .enlace-olvido a{
            color: #60a5fa;
            text-decoration: none;
        }
        .enlace-olvido a:hover{
            text-decoration: underline;
        }
        button[type="submit"]{
            margin-top: 0.5rem;
            padding: 0.7rem 1rem;
            border: none;
            border-radius: 999px;
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: #f9fafb;
            font-weight: 600;
            letter-spacing: 0.03em;
            cursor: pointer;
            font-size: 0.95rem;
            box-shadow: 0 10px 25px rgba(37, 99, 235, 0.4);
            transition: transform 0.15s ease, box-shadow 0.15s ease, filter 0.15s ease;
        }
        button[type="submit"]:hover{
            transform: translateY(-1px);
            filter: brightness(1.05);
            box-shadow: 0 14px 35px rgba(37, 99, 235, 0.55);
        }
        .login-footer{
            margin-top: 1.2rem;
            text-align: center;
            font-size: 0.8rem;
            color: #6b7280;
        }
        .login-footer a{
            color: #93c5fd;
            text-decoration: none;
        }
        .login-footer a:hover{
            text-decoration: underline;
        }

        @media (max-width: 480px){
            .login-card{
                padding: 1.7rem 1.4rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <div class="login-card">
            <div class="login-header">
                <h1>Iniciar sesión</h1>
                <p>Accede al gestor de incidencias con tu usuario y contraseña.</p>
            </div>

            <form action="../src/controllers/procesar-login.php" method="post">
                <div class="campo">
                    <label for="email">Correo electrónico</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        placeholder="tu_correo@empresa.com"
                        required
                    >
                </div>

                <div class="campo">
                    <label for="password">Contraseña</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Introduce tu contraseña"
                        required
                    >
                </div>

                <div class="fila-opciones">
                    <label class="recordar">
                        <input type="checkbox" name="recordar" id="recordar">
                        Recordar sesión
                    </label>
                    <div class="enlace-olvido">
                        <a href="#">¿Has olvidado tu contraseña?</a>
                    </div>
                </div>

                <button type="submit">Entrar</button>
            </form>
            <?php if (isset($_SESSION["errores"])):?>
                <?php foreach ($_SESSION["errores"] as $error): ?>
                    <p style="color: red;"><?= $error ?></p>
                <?php endforeach; ?>
            <?php endif; ?>    
            <div class="login-footer">
                <span>Gestor de Incidencias &bull; Proyecto PHP</span>
            </div>
            
        </div>
    </div>
</body>
</html>