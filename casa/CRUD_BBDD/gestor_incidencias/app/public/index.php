<?php
session_start();
require __DIR__."/../vendor/autoload.php";
use App\models\Basedatos;
$mensaje="";
$mibd=new Basedatos();
if ($mibd===null) {
    $mensaje="ERROR AL CONECTAR";
}
else{
    header("Location:login.php");
    die;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestor de Incidencias</title>
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
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            color: #f5f5f5;
        }
        .contenedor{
            text-align: center;
            padding: 2.5rem 3rem;
            background-color: rgba(0,0,0,0.25);
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.35);
            max-width: 480px;
            width: 90%;
        }
        h1{
            font-size: 2rem;
            margin-bottom: 1rem;
        }
        p{
            margin-bottom: 2rem;
            line-height: 1.5;
        }
        a.boton{
            display: inline-block;
            padding: 0.75rem 1.8rem;
            border-radius: 999px;
            background-color: #ffb703;
            color: #1f2933;
            text-decoration: none;
            font-weight: 600;
            letter-spacing: 0.03em;
            box-shadow: 0 5px 15px rgba(0,0,0,0.25);
            transition: transform 0.15s ease, box-shadow 0.15s ease, background-color 0.15s ease;
        }
        a.boton:hover{
            background-color: #ffd166;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.35);
        }
        small{
            display: block;
            margin-top: 1rem;
            opacity: 0.8;
            font-size: 0.8rem;
        }
    </style>
</head>
<body>
    <div class="contenedor">
        <h1>Gestor de Incidencias</h1>
        <p>
            Bienvenido al sistema de gestión de incidencias.<br>
            Más adelante, desde este archivo se realizará la comprobación
            de conexión y la redirección automática al formulario de login.
        </p>
        <p><?= $mensaje ?></p>
        <a href="login.php" class="boton">Ir al login</a>
        <small>Versión de prueba &bull; Vista de entrada</small>
    </div>
</body>
</html>