<?php
session_start();
require __DIR__ . "/../../vendor/autoload.php";

use App\Models\Basedatos;
use App\Models\Usuarios;

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

/* ==== LISTA DE CLIENTES PARA EL SELECT ==== */
$sqlClientes = "SELECT id, nombre FROM clientes ORDER BY nombre ASC";
$sentenciaClientes = $basedatos->get_data($sqlClientes, []);
$listaClientes = $sentenciaClientes ? $sentenciaClientes->fetchAll(PDO::FETCH_OBJ) : [];

/* ==== ERRORES Y DATOS PREVIOS (opcional) ==== */
$errores = $_SESSION['errores_paquetes'] ?? [];
unset($_SESSION['errores_paquetes']);

$datosPrevios = $_SESSION['datos_paquetes'] ?? [];
unset($_SESSION['datos_paquetes']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nuevo paquete - Gestor de Paquetería</title>
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
        .btn-primario {
            background-color: #2563eb;
            color: #ffffff;
        }
        .form-card {
            background: #ffffff;
            border-radius: 8px;
            padding: 1.4rem 1.5rem;
            box-shadow: 0 2px 6px rgba(0,0,0,0.06);
        }
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
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
        select,
        input[type="text"],
        textarea {
            padding: 0.5rem 0.6rem;
            border-radius: 6px;
            border: 1px solid #d1d5db;
            font-size: 0.9rem;
            font-family: inherit;
        }
        textarea {
            resize: vertical;
            min-height: 80px;
        }
        select:focus,
        input:focus,
        textarea:focus {
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
            <h2>Nuevo paquete</h2>
            <p>Rellena los datos del envío para dar de alta un nuevo paquete.</p>
        </div>
        <div class="acciones-cabecera">
            <a href="paquetes_listar.php" class="btn btn-secundario">Volver al listado</a>
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

        <!-- Script procesador -->
        <form action="../Controllers/procesar-paquete-nuevo.php" method="post">
            <div class="form-grid">
                <div class="form-group">
                    <label for="id_cliente">Cliente</label>
                    <select id="id_cliente" name="id_cliente" required>
                        <option value="">Selecciona un cliente…</option>
                        <?php foreach ($listaClientes as $cliente): ?>
                            <option
                                value="<?= htmlspecialchars($cliente->id) ?>"
                                <?php if (($datosPrevios['id_cliente'] ?? '') == $cliente->id) echo 'selected'; ?>
                            >
                                <?= htmlspecialchars($cliente->nombre) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group" style="grid-column: 1 / -1;">
                    <label for="descripcion">Descripción del paquete</label>
                    <input
                        type="text"
                        id="descripcion"
                        name="descripcion"
                        required
                        placeholder="Ej: Caja mediana - componentes PC"
                        value="<?= htmlspecialchars($datosPrevios['descripcion'] ?? '') ?>"
                    >
                </div>

                <div class="form-group">
                    <label for="estado">Estado inicial</label>
                    <select id="estado" name="estado" required>
                        <?php
                        $estadoSeleccionado = $datosPrevios['estado'] ?? 'pendiente';
                        $estados = [
                            'pendiente'  => 'Pendiente',
                            'en_reparto' => 'En reparto',
                            'entregado'  => 'Entregado',
                            'incidencia' => 'Incidencia'
                        ];
                        foreach ($estados as $valorEstado => $textoEstado):
                        ?>
                            <option
                                value="<?= $valorEstado ?>"
                                <?php if ($estadoSeleccionado === $valorEstado) echo 'selected'; ?>
                            >
                                <?= $textoEstado ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group" style="grid-column: 1 / -1;">
                    <label for="notas">Notas (opcional)</label>
                    <textarea
                        id="notas"
                        name="notas"
                        placeholder="Observaciones para el reparto, incidencias, etc."
                    ><?= htmlspecialchars($datosPrevios['notas'] ?? '') ?></textarea>
                </div>
            </div>

            <div class="acciones-formulario">
                <a href="paquetes_listar.php" class="btn-link">Cancelar</a>
                <button type="submit" class="btn btn-primario">Guardar paquete</button>
            </div>
        </form>
    </section>
</main>
</body>
</html>
