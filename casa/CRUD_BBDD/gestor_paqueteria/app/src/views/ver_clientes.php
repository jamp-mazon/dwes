<?php
session_start();
require __DIR__ . "/../../vendor/autoload.php";

use App\Models\Basedatos;
use App\Models\Usuarios;
use App\Models\Clientes;

// Comprobamos sesión
if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit;
}

$mibd = new Basedatos();

/* ==== USUARIO LOGEADO PARA EL HEADER ==== */
$parametros = [":id" => $_SESSION["id"]];
$sqlUsuario = "SELECT * FROM usuarios WHERE id = :id";
$sentenciaUsuario = $mibd->get_data($sqlUsuario, $parametros);
$registroPDO = $sentenciaUsuario ? $sentenciaUsuario->fetch(PDO::FETCH_OBJ) : null;

if ($registroPDO) {
    $nuevo_usuario = new Usuarios(
        $registroPDO->id,
        $registroPDO->nombre,
        $registroPDO->email,
        $registroPDO->password_hash,
        $registroPDO->rol,
        $registroPDO->creado_en
    );
} else {
    // Si falla, mejor redirigir al login para evitar fatal
    header('Location: login.php');
    exit;
}

/* ==== OBTENER CLIENTES ==== */
$clientes = $mibd->obtener_clientes();   // debe devolver array de clientes
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de clientes - Gestor de Paquetería</title>
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
            max-width: 1100px;
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
        .btn-primario {
            background-color: #2563eb;
            color: #ffffff;
        }
        .btn-secundario {
            background-color: #e5e7eb;
            color: #111827;
            border-color: #d1d5db;
        }
        .tabla-contenedor {
            background: #ffffff;
            border-radius: 8px;
            padding: 1rem 1.2rem;
            box-shadow: 0 2px 6px rgba(0,0,0,0.06);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.9rem;
        }
        thead {
            background-color: #e5e7eb;
        }
        th, td {
            padding: 0.6rem 0.7rem;
            text-align: left;
        }
        th {
            font-weight: 600;
            color: #374151;
        }
        tbody tr:nth-child(even) {
            background-color: #f9fafb;
        }
        tbody tr:hover {
            background-color: #eff6ff;
        }
        .texto-centrado {
            text-align: center;
            color: #4b5563;
        }
        @media (max-width: 700px) {
            .cabecera-pagina {
                flex-direction: column;
                align-items: flex-start;
            }
            table {
                font-size: 0.8rem;
            }
            th, td {
                padding: 0.4rem 0.45rem;
            }
        }
    </style>
</head>
<body>
<header>
    <h1>Gestor de Paquetería</h1>
    <div class="user-info">
        <span>Sesión iniciada como: <strong><?= htmlspecialchars($nuevo_usuario->getNombre()) ?></strong></span>
        <a href="logout.php" class="btn-logout">Cerrar sesión</a>
    </div>
</header>

<main>
    <section class="cabecera-pagina">
        <div>
            <h2>Listado de clientes</h2>
            <p>Aquí puedes consultar todos los clientes registrados en el sistema.</p>
        </div>
        <div class="acciones-cabecera">
            <a href="dashboard.php" class="btn btn-secundario">Volver al panel</a>
            <a href="clientes_nuevos.php" class="btn btn-primario">Nuevo cliente</a>
            <a href="../Controllers/descargar-clientes.php" class="btn btn-secundario">Descargar PDF</a>
        </div>
    </section>

    <section class="tabla-contenedor">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Teléfono</th>
                    <th>Dirección</th>
                    <th>Ciudad</th>
                    <th>C.P.</th>
                    <th>Cliente desde</th>
                </tr>
            </thead>
            <tbody>
            <?php if (empty($clientes)): ?>
                <tr>
                    <td colspan="7" class="texto-centrado">No hay clientes registrados todavía.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($clientes as $cliente): ?>
                    <?php
                    // Soporta que $cliente sea array o stdClass
                    $id       = is_array($cliente) ? ($cliente['id'] ?? '') : ($cliente->id ?? '');
                    $nombre   = is_array($cliente) ? ($cliente['nombre'] ?? '') : ($cliente->nombre ?? '');
                    $tel      = is_array($cliente) ? ($cliente['telefono'] ?? '') : ($cliente->telefono ?? '');
                    $dir      = is_array($cliente) ? ($cliente['direccion'] ?? '') : ($cliente->direccion ?? '');
                    $ciudad   = is_array($cliente) ? ($cliente['ciudad'] ?? '') : ($cliente->ciudad ?? '');
                    $cp       = is_array($cliente) ? ($cliente['cp'] ?? '') : ($cliente->cp ?? '');
                    $desde    = is_array($cliente) ? ($cliente['cliente_desde'] ?? '') : ($cliente->cliente_desde ?? '');
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($id) ?></td>
                        <td><?= htmlspecialchars($nombre) ?></td>
                        <td><?= htmlspecialchars($tel) ?></td>
                        <td><?= htmlspecialchars($dir) ?></td>
                        <td><?= htmlspecialchars($ciudad) ?></td>
                        <td><?= htmlspecialchars($cp) ?></td>
                        <td><?= htmlspecialchars($desde) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </section>
</main>
</body>
</html>
