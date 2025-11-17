<?php
session_start();

// Aquí asumimos que en el login has guardado algo como:
// $_SESSION['usuario'] = ['id' => 1, 'nombre' => 'Admin General', 'email' => '...'];

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

$usuario = $_SESSION['usuario'];
$nombreUsuario = is_array($usuario) ? $usuario['nombre'] : $usuario; // ajústalo a tu estructura
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
            box-shadow: 0 2px 6px rgba(0,0,0,0.06);
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
        <span>Sesión iniciada como: <strong></strong></span>
        <!-- Enlaza esto a un script logout.php que haga session_destroy() -->
        <a href="logout.php" class="btn-logout">Cerrar sesión</a>
    </div>
</header>

<main>
    <section class="bienvenida">
        <h2>Panel principal</h2>
        <p>Desde aquí puedes gestionar clientes, paquetes y consultar el estado de los envíos.</p>
    </section>

    <section class="grid-panel">
        <!-- Bloque: Gestión de clientes -->
        <article class="card">
            <h3>Clientes</h3>
            <p>Alta, edición y consulta de los clientes destinatarios de los envíos.</p>
            <div class="acciones">
                <a href="clientes_listar.php" class="btn btn-primario">Ver todos los clientes</a>
                <a href="clientes_nuevo.php" class="btn btn-secundario">Nuevo cliente</a>
            </div>
        </article>

        <!-- Bloque: Gestión de paquetes -->
        <article class="card">
            <h3>Paquetes</h3>
            <p>Gestiona los paquetes: altas, cambios de estado y eliminación.</p>
            <div class="acciones">
                <a href="paquetes_listar.php" class="btn btn-primario">Ver todos los paquetes</a>
                <a href="paquetes_nuevo.php" class="btn btn-secundario">Nuevo paquete</a>
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
                    <!-- Ejemplo: <small>12 paquetes</small> -->
                </a>
                <a href="paquetes_listar.php?estado=en_reparto" class="estado-card">
                    <span>En reparto</span><br>
                </a>
                <a href="paquetes_listar.php?estado=entregado" class="estado-card">
                    <span>Entregados</span><br>
                </a>
                <a href="paquetes_listar.php?estado=incidencia" class="estado-card">
                    <span>Incidencias</span><br>
                </a>
            </div>
        </article>
    </section>
</main>
</body>
</html>
