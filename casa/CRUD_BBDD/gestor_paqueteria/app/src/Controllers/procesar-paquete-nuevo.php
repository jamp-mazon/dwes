<?php
session_start();
require __DIR__ . "/../../vendor/autoload.php";

use App\Models\Basedatos;
use App\Models\Paquetes;

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../views/paquetes_nuevos.php");
    exit;
}

$_SESSION["errores_paquetes"] = [];
$_SESSION["datos_paquetes"] = $_POST;

$todoOk = true;
$id_cliente  = $_POST["id_cliente"]   ?? ($todoOk = false);
$descripcion = $_POST["descripcion"]  ?? ($todoOk = false);
$estado      = $_POST["estado"]       ?? ($todoOk = false);
$notas       = $_POST["notas"]        ?? null;

// Validaciones básicas
$estadosValidos = ['pendiente', 'en_reparto', 'entregado', 'incidencia'];
if (!$todoOk) {
    if (!$id_cliente)  { $_SESSION["errores_paquetes"][] = "Debes seleccionar un cliente."; }
    if (!$descripcion) { $_SESSION["errores_paquetes"][] = "La descripción es obligatoria."; }
    if (!$estado)      { $_SESSION["errores_paquetes"][] = "El estado es obligatorio."; }
    header("Location: ../views/paquetes_nuevos.php");
    exit;
}

if (!ctype_digit((string)$id_cliente)) {
    $_SESSION["errores_paquetes"][] = "El cliente no es válido.";
}
if (!in_array($estado, $estadosValidos, true)) {
    $_SESSION["errores_paquetes"][] = "El estado seleccionado no es válido.";
}

if (!empty($_SESSION["errores_paquetes"])) {
    header("Location: ../views/paquetes_nuevos.php");
    exit;
}

$descripcion = trim($descripcion);
$notas = $notas !== null ? trim($notas) : null;

$bd = new Basedatos();
if (!$bd->getConectada()) {
    $_SESSION["errores_paquetes"][] = "No hay conexión con la base de datos.";
    header("Location: ../views/paquetes_nuevos.php");
    exit;
}

$fechaCreacion = date("Y-m-d H:i:s");
$paquete = new Paquetes(
    null,
    (int)$id_cliente,
    $descripcion,
    $fechaCreacion,
    $estado,
    $notas
);

$idNuevo = $bd->crear_paquete($paquete);
if ($idNuevo === null) {
    $_SESSION["errores_paquetes"][] = "No se pudo crear el paquete. Inténtalo más tarde.";
    header("Location: ../views/paquetes_nuevos.php");
    exit;
}

// Limpia datos previos y redirige al listado
unset($_SESSION["datos_paquetes"]);
header("Location: ../views/paquetes_listar.php");
exit;
