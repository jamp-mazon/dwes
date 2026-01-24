<?php
session_start();
require __DIR__ . "/../../vendor/autoload.php";

use App\Models\Basedatos;
use App\Models\Usuarios;

if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit;
}

$bd = new Basedatos();

/* ==== USUARIO LOGEADO PARA EL HEADER ==== */
$parametros = [":id" => $_SESSION["id"]];
$sqlUsuario = "SELECT * FROM usuarios WHERE id = :id";
$sentenciaUsuario = $bd->get_data($sqlUsuario, $parametros);
$registroPDO = $sentenciaUsuario ? $sentenciaUsuario->fetch(PDO::FETCH_OBJ) : null;

if (!$registroPDO) {
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

/* ==== FILTRO POR ESTADO (desde ?estado=pendiente, en_reparto, entregado, incidencia) ==== */
$estadosValidos = ['pendiente', 'en_reparto', 'entregado', 'incidencia'];
$estadoFiltro = $_GET['estado'] ?? 'todos';

if (!in_array($estadoFiltro, $estadosValidos) && $estadoFiltro !== 'todos') {
    $estadoFiltro = 'todos';
}

/* ==== OBTENER PAQUETES ==== */
if ($estadoFiltro === 'todos') {
    $sqlPaquetes = "
        SELECT p.*, c.nombre AS cliente_nombre
        FROM paquetes p
        JOIN clientes c ON p.id_cliente = c.id
        ORDER BY p.fecha_creacion DESC
    ";
    $sentenciaPaquetes = $bd->get_data($sqlPaquetes, []);
} else {
    $sqlPaquetes = "
        SELECT p.*, c.nombre AS cliente_nombre
        FROM paquetes p
        JOIN clientes c ON p.id_cliente = c.id
        WHERE p.estado = :estado
        ORDER BY p.fecha_creacion DESC
    ";
    $sentenciaPaquetes = $bd->get_data($sqlPaquetes, [":estado" => $estadoFiltro]);
}

$paquetes = $sentenciaPaquetes ? $sentenciaPaquetes->fetchAll(PDO::FETCH_OBJ) : [];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de paquetes - Gestor de Paquetería</title>
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
        .acciones-cabecera,
        .filtros-estado {
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
        .btn-filtro {
            background-color: #eef2ff;
            color: #111827;
            border-color: #c7d2fe;
            font-size: 0.85rem;
        }
        .btn-filtro-activo {
            background-color: #2563eb;
            color: #ffffff;
            border-color: #2563eb;
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
        .badge-estado {
            display: inline-block;
            padding: 0.15rem 0.55rem;
            border-radius: 999px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        .badge-pendiente {
            background-color: #fef3c7;
            color: #92400e;
        }
        .badge-en_reparto {
            background-color: #dbeafe;
            color: #1d4ed8;
        }
        .badge-entregado {
            background-color: #dcfce7;
            color: #166534;
        }
        .badge-incidencia {
            background-color: #fee2e2;
            color: #b91c1c;
        }
        @media (max-width: 800px) {
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
        <span>Sesión iniciada como: <strong><?= htmlspecialchars($usuarioActual->getNombre()) ?></strong></span>
        <a href="logout.php" class="btn-logout">Cerrar sesión</a>
    </div>
</header>

<main>
    <section class="cabecera-pagina">
        <div>
            <h2>Listado de paquetes</h2>
            <p>Consulta los envíos y su estado actual.</p>
        </div>
        <div class="acciones-cabecera">
            <a href="dashboard.php" class="btn btn-secundario">Volver al panel</a>
            <a href="paquetes_nuevos.php" class="btn btn-primario">Nuevo paquete</a>
            <a href="../Controllers/descargar-paquetes.php" class="btn btn-secundario">Descargar PDF</a>
        </div>
    </section>

    <section style="margin-bottom: 1rem;">
        <div class="filtros-estado">
            <?php
            $estadosLinks = [
                'todos'      => 'Todos',
                'pendiente'  => 'Pendientes',
                'en_reparto' => 'En reparto',
                'entregado'  => 'Entregados',
                'incidencia' => 'Incidencias'
            ];
            foreach ($estadosLinks as $clave => $texto):
                $claseExtra = ($estadoFiltro === $clave) ? ' btn-filtro-activo' : '';
            ?>
                <a href="paquetes_listar.php?estado=<?= $clave ?>"
                   class="btn btn-filtro<?= $claseExtra ?>">
                    <?= $texto ?>
                </a>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="tabla-contenedor">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Descripción</th>
                    <th>Estado</th>
                    <th>Notas</th>
                    <th>Fecha creación</th>
                </tr>
            </thead>
            <tbody>
            <?php if (empty($paquetes)): ?>
                <tr>
                    <td colspan="6" class="texto-centrado">No hay paquetes para el filtro seleccionado.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($paquetes as $p): ?>
                    <?php
                        $estado = $p->estado;
                        $claseBadge = 'badge-' . $estado;
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($p->id) ?></td>
                        <td><?= htmlspecialchars($p->cliente_nombre) ?></td>
                        <td><?= htmlspecialchars($p->descripcion) ?></td>
                        <td>
                            <span class="badge-estado <?= $claseBadge ?>">
                                <?= htmlspecialchars($estado) ?>
                            </span>
                        </td>
                        <td><?= htmlspecialchars($p->notas ?? '') ?></td>
                        <td><?= htmlspecialchars($p->fecha_creacion) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </section>
</main>
</body>
</html>
