<?php
session_start();
require __DIR__ . "/../../vendor/autoload.php";

use App\Models\Basedatos;
use App\Models\Usuarios;

// Comprobamos sesión
if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit;
}

$basedatos = new Basedatos();

/* ==== USUARIO LOGEADO PARA EL HEADER ==== */
$parametros = [":id" => $_SESSION["id"]];
$sqlUsuario = "SELECT * FROM usuarios WHERE id = :id";
$sentenciaUsuario = $basedatos->get_data($sqlUsuario, $parametros);
$registroPDO = $sentenciaUsuario ? $sentenciaUsuario->fetch(PDO::FETCH_OBJ) : null;

if (!$registroPDO) {
    // Si no se puede recuperar el usuario, vuelve al login para evitar errores fatales
    header('Location: login.php');
    exit;
}

$usuarioActual = new Usuarios(
    $registroPDO->id,
    $registroPDO->nombre,
    $registroPDO->email,
    $registroPDO->password_hash,
    $registroPDO->rol,
    $registroPDO->creado_en
);

// Aquí podrías recuperar errores de validación de la sesión si el procesador los deja ahí
$errores = $_SESSION['errores_clientes'] ?? [];
unset($_SESSION['errores_clientes']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nuevo cliente - Gestor de Paquetería</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background-color: #f4f6f8;
        }
        header {
            background-color: #1f2933;
            color: #f9fafb;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        header h1 {
            margin: 0;
            font-size: 1.4rem;
        }
        .user-info {
            display: flex;
            align-items: center;
            gap: 1rem;
            font-size: 0.95rem;
        }
        .btn-logout {
            padding: 0.4rem 0.8rem;
            border-radius: 4px;
            border: none;
            background-color: #ef4444;
            color: #fff;
            cursor: pointer;
            text-decoration: none;
            font-size: 0.9rem;
        }
        main {
            max-width: 900px;
            margin: 2rem auto;
            padding: 0 1rem;
        }
        .cabecera-pagina {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        .cabecera-pagina h2 {
            margin: 0;
            font-size: 1.3rem;
            color: #111827;
        }
        .cabecera-pagina p {
            margin: 0.2rem 0 0;
            color: #4b5563;
            font-size: 0.95rem;
        }
        .acciones-cabecera {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }
        .btn {
            display: inline-block;
            padding: 0.5rem 0.9rem;
            border-radius: 6px;
            text-decoration: none;
            font-size: 0.9rem;
            border: 1px solid transparent;
            cursor: pointer;
        }
        .btn-secundario {
            background-color: #e5e7eb;
            color: #111827;
            border-color: #d1d5db;
        }
        .form-card {
            background: #ffffff;
            border-radius: 8px;
            padding: 1.4rem 1.5rem;
            box-shadow: 0 2px 6px rgba(0,0,0,0.06);
        }
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
            gap: 1rem 1.5rem;
        }
        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }
        label {
            font-size: 0.9rem;
            font-weight: 600;
            color: #374151;
        }
        input[type="text"],
        input[type="tel"] {
            padding: 0.5rem 0.6rem;
            border-radius: 6px;
            border: 1px solid #d1d5db;
            font-size: 0.9rem;
        }
        input:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 1px rgba(37,99,235,0.25);
        }
        .acciones-formulario {
            margin-top: 1.3rem;
            display: flex;
            justify-content: flex-end;
            gap: 0.6rem;
        }
        .btn-primario {
            background-color: #2563eb;
            color: #ffffff;
        }
        .btn-link {
            background: transparent;
            border: none;
            color: #4b5563;
            text-decoration: none;
            font-size: 0.9rem;
            padding: 0.5rem 0.6rem;
            cursor: pointer;
        }
        .errores {
            margin-bottom: 1rem;
            padding: 0.8rem 0.9rem;
            border-radius: 6px;
            background-color: #fee2e2;
            color: #b91c1c;
            font-size: 0.9rem;
        }
        .errores ul {
            margin: 0;
            padding-left: 1.2rem;
        }
        @media (max-width: 700px) {
            .cabecera-pagina {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
</head>
<body>
<header>
    <h1>Gestor de Paquetería</h1>
    <div class="user-info">
        <span>Sesión iniciada como: <strong><?= htmlspecialchars($usuarioActual->getNombre()) ?></strong></span>
        <a href="logout.php" class="btn-logout">Cerrar sesión</a>
    </div>
</header>

<main>
    <section class="cabecera-pagina">
        <div>
            <h2>Nuevo cliente</h2>
            <p>Rellena el formulario para dar de alta un nuevo cliente destinatario.</p>
        </div>
        <div class="acciones-cabecera">
            <a href="ver_clientes.php" class="btn btn-secundario">Volver al listado</a>
        </div>
    </section>

    <section class="form-card">
        <?php if (!empty($errores)): ?>
            <div class="errores">
                <strong>Se han encontrado errores:</strong>
                <ul>
                    <?php foreach ($errores as $mensajeError): ?>
                        <li><?= htmlspecialchars($mensajeError) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="../Controllers/procesar-nuevo-cliente.php" method="post">
            <div class="form-grid">
                <div class="form-group">
                    <label for="nombre">Nombre completo</label>
                    <input
                        type="text"
                        id="nombre"
                        name="nombre"
                        required
                        placeholder="Nombre del cliente"
                    >
                </div>

                <div class="form-group">
                    <label for="telefono">Teléfono</label>
                    <input
                        type="tel"
                        id="telefono"
                        name="telefono"
                        required
                        placeholder="Ej: 600123456"
                    >
                </div>

                <div class="form-group" style="grid-column: 1 / -1;">
                    <label for="direccion">Dirección</label>
                    <input
                        type="text"
                        id="direccion"
                        name="direccion"
                        required
                        placeholder="Calle, número, piso…"
                    >
                </div>

                <div class="form-group">
                    <label for="ciudad">Ciudad</label>
                    <input
                        type="text"
                        id="ciudad"
                        name="ciudad"
                        required
                        placeholder="Ciudad"
                    >
                </div>

                <div class="form-group">
                    <label for="cp">Código postal</label>
                    <input
                        type="text"
                        id="cp"
                        name="cp"
                        required
                        placeholder="Ej: 30001"
                    >
                </div>
            </div>

            <div class="acciones-formulario">
                <a href="ver_clientes.php" class="btn-link">Cancelar</a>
                <button type="submit" class="btn btn-primario">Guardar cliente</button>
            </div>
        </form>
    </section>
</main>
</body>
</html>
