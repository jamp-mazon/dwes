<?php
session_start();
require __DIR__ . "/../../vendor/autoload.php";

use App\Models\Usuarios;
use App\Models\Basedatos;

// Aquí asumimos que en el login has guardado algo como:
// $_SESSION['usuario'] = ['id' => 1, 'nombre' => 'Admin General', 'email' => '...'];

if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit;
} else {
    $mibd = new Basedatos();
    $parametros = [":id" => $_SESSION["id"]];
    // Tabla en minúsculas como está creada en MySQL
    $sql = "SELECT * FROM usuarios WHERE id=:id";
    $sentencia = $mibd->get_data($sql, $parametros);
    $registroPDO = $sentencia ? $sentencia->fetch(PDO::FETCH_OBJ) : null;
    if (!$registroPDO) {
        header('Location: login.php');
        exit;
    }
    $nuevo_usuario = new Usuarios(
        $registroPDO->id,
        $registroPDO->nombre,
        $registroPDO->email,
        $registroPDO->password_hash,
        $registroPDO->rol,
        $registroPDO->creado_en
    );
}
/* ===================== MÉTRICAS ===================== */

// Total clientes
$sqlTotalClientes = "SELECT COUNT(*) AS total_clientes FROM clientes";
$stmtClientes = $mibd->get_data($sqlTotalClientes, []);
$totalClientes = $stmtClientes ? (int)($stmtClientes->fetch(PDO::FETCH_OBJ)->total_clientes ?? 0) : 0;

// Total paquetes
$sqlTotalPaquetes = "SELECT COUNT(*) AS total_paquetes FROM paquetes";
$stmtPaquetes = $mibd->get_data($sqlTotalPaquetes, []);
$totalPaquetes = $stmtPaquetes ? (int)($stmtPaquetes->fetch(PDO::FETCH_OBJ)->total_paquetes ?? 0) : 0;

// Paquetes por estado
$estados = [
    'pendiente'   => 0,
    'en_reparto'  => 0,
    'entregado'   => 0,
    'incidencia'  => 0,
];

$sqlEstados = "SELECT estado, COUNT(*) AS total FROM paquetes GROUP BY estado";
$stmtEstados = $mibd->get_data($sqlEstados, []);
if ($stmtEstados) {
    while ($row = $stmtEstados->fetch(PDO::FETCH_OBJ)) {
        if (isset($estados[$row->estado])) {
            $estados[$row->estado] = (int)$row->total;
        }
    }
}

// Porcentaje de paquetes en reparto (para la barra de progreso)
$porcentajeEnReparto = 0;
if ($totalPaquetes > 0) {
    $porcentajeEnReparto = round(($estados['en_reparto'] / $totalPaquetes) * 100);
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Panel de gestión - Gestor de Paquetería</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * {
            box-sizing: border-box;
        }

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

        .bienvenida {
            margin-bottom: 1.5rem;
        }

        .bienvenida h2 {
            margin: 0 0 0.3rem 0;
            font-size: 1.3rem;
            color: #111827;
        }

        .bienvenida p {
            margin: 0;
            color: #4b5563;
            font-size: 0.95rem;
        }

        .grid-panel {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 1.5rem;
        }

        .card {
            background: #ffffff;
            border-radius: 8px;
            padding: 1.2rem 1.3rem;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.06);
        }

        .card h3 {
            margin-top: 0;
            margin-bottom: 0.7rem;
            font-size: 1.1rem;
            color: #111827;
        }

        .card p {
            margin-top: 0;
            margin-bottom: 1rem;
            font-size: 0.9rem;
            color: #4b5563;
        }

        .acciones {
            display: flex;
            flex-wrap: wrap;
            gap: 0.6rem;
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

        .estadisticas-estado {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 0.5rem;
        }

        .estado-card {
            display: block;
            padding: 0.6rem 0.7rem;
            border-radius: 6px;
            background-color: #eef2ff;
            font-size: 0.9rem;
            text-decoration: none;
            color: #111827;
        }

        .estado-card span {
            font-weight: 600;
        }

        * Métricas mini-cards */ .metricas {
            margin-top: 0.5rem;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 0.6rem;
        }

        .metrica {
            background-color: #f9fafb;
            border-radius: 6px;
            padding: 0.5rem 0.6rem;
            font-size: 0.9rem;
        }

        .metrica-titulo {
            font-size: 0.8rem;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: .05em;
        }

        .metrica-valor {
            font-size: 1.2rem;
            font-weight: 700;
            color: #111827;
        }

        /* Texto pequeño en tarjetas de estado */
        .estado-card small {
            color: #4b5563;
            font-weight: 400;
        }

        .resumen-panel {
            margin-top: 1.5rem;
        }

        .resumen-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 1rem;
        }

        .resumen-card,
        .progreso-card {
            margin-top: 20px;
            background: #ffffff;
            border-radius: 8px;
            padding: 1rem 1.2rem;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.06);
        }

        .resumen-titulo {
            font-size: 0.8rem;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: .06em;
        }

        .resumen-valor {
            font-size: 1.6rem;
            font-weight: 700;
            color: #111827;
            margin-top: 0.25rem;
        }

        .resumen-sub {
            font-size: 0.85rem;
            color: #6b7280;
            margin-top: 0.25rem;
        }

        /* Barra de progreso (puedes reutilizar si ya lo tenías) */
        .progreso-wrapper {
            margin-top: 0.8rem;
        }

        .progreso-label {
            display: flex;
            justify-content: space-between;
            font-size: 0.85rem;
            color: #4b5563;
            margin-bottom: 0.3rem;
        }

        .progreso-barra {
            width: 100%;
            height: 12px;
            border-radius: 999px;
            background-color: #e5e7eb;
            overflow: hidden;
        }

        .progreso-inner {
            height: 100%;
            border-radius: inherit;
            background: linear-gradient(90deg, #2563eb, #22c55e);
            transition: width 0.3s ease;
        }


        @media (max-width: 600px) {
            header {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.6rem;
            }
        }
    </style>
</head>

<body>
    <header>
        <h1>Gestor de Paquetería</h1>
        <div class="user-info">
            <span>Sesión iniciada como: <strong><?= $nuevo_usuario->getNombre() ?></strong></span>
            <!-- Enlaza esto a un script logout.php que haga session_destroy() -->
            <a href="logout.php" class="btn-logout">Cerrar sesión</a>
        </div>
    </header>

    <main>
        <section class="bienvenida">
            <h2>Panel principal</h2>
            <p>Desde aquí puedes gestionar clientes, paquetes y consultar el estado de los envíos.</p>
            <p><strong>Total clientes:</strong> <?= $totalClientes ?> · <strong>Total paquetes:</strong> <?= $totalPaquetes ?> · <strong>En reparto:</strong> <?= $estados['en_reparto'] ?> (<?= $porcentajeEnReparto ?>%)</p>
        </section>

        <section class="grid-panel">
            <!-- Bloque: Gestión de clientes -->
            <article class="card">
                <h3>Clientes</h3>
                <p>Alta, edición y consulta de los clientes destinatarios de los envíos.</p>
                <div class="acciones">
                    <a href="ver_clientes.php" class="btn btn-primario">Ver todos los clientes</a>
                    <a href="clientes_nuevos.php" class="btn btn-secundario">Nuevo cliente</a>
                </div>

            </article>

            <!-- Bloque: Gestión de paquetes -->
            <article class="card">
                <h3>Paquetes</h3>
                <p>Gestiona los paquetes: altas, cambios de estado y eliminación.</p>
                <div class="acciones">
                    <a href="paquetes_listar.php" class="btn btn-primario">Ver todos los paquetes</a>
                    <a href="paquetes_nuevos.php" class="btn btn-secundario">Nuevo paquete</a>
                </div>
            </article>

            <!-- Bloque: Estados rápidos de paquetes -->
            <article class="card">
                <h3>Estados de los paquetes</h3>
                <p>Accesos rápidos a los paquetes según su estado actual.</p>
                <div class="estadisticas-estado">
                    <!-- Más adelante aquí puedes pintar contadores desde PHP (pendientes, entregados, etc.) -->
                    <a href="paquetes_listar.php?estado=pendiente" class="estado-card">
                        <span>Pendientes</span><br>
                        <small><?= $estados['pendiente'] ?> paquetes</small>
                    </a>
                    <a href="paquetes_listar.php?estado=en_reparto" class="estado-card">
                        <span>En reparto</span><br>
                        <small><?= $estados['en_reparto'] ?> paquetes</small>
                    </a>
                    <a href="paquetes_listar.php?estado=entregado" class="estado-card">
                        <span>Entregados</span><br>
                        <small><?= $estados['entregado'] ?> paquetes</small>
                    </a>
                    <a href="paquetes_listar.php?estado=incidencia" class="estado-card">
                        <span>Incidencias</span><br>
                        <small><?= $estados['incidencia'] ?> paquetes</small>
                    </a>
                </div>
            </article>
        </section>
        <section class="resumen-panel">
            <!-- Fila 2: dos tarjetas de métricas centradas debajo de las de arriba -->
            <div class="resumen-grid">
                <article class="resumen-card">
                    <div class="resumen-titulo">Clientes</div>
                    <div class="resumen-valor"><?= $totalClientes ?></div>
                    <div class="resumen-sub">Clientes registrados</div>
                </article>

                <article class="resumen-card">
                    <div class="resumen-titulo">Paquetes</div>
                    <div class="resumen-valor"><?= $totalPaquetes ?></div>
                    <div class="resumen-sub">Totales</div>
                    <div class="resumen-sub">
                        En reparto: <strong><?= $estados['en_reparto'] ?></strong>
                    </div>
                </article>
            </div>

            <!-- Fila 3: la barra de progreso ocupando todo el ancho -->
            <article class="progreso-card">
                <div class="resumen-titulo">Progreso en reparto</div>
                <div class="progreso-label">
                    <span><?= $estados['en_reparto'] ?> en reparto</span>
                    <span>
                        <?= $estados['en_reparto'] ?> / <?= $totalPaquetes ?> paquetes
                        (<?= $porcentajeEnReparto ?>%)
                    </span>
                </div>
                <div class="progreso-barra">
                    <div class="progreso-inner" style="width: <?= $porcentajeEnReparto ?>%;"></div>
                </div>
            </article>
        </section>
    </main>
</body>

</html>