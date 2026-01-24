<?php
session_start();
require __DIR__ . "/../../vendor/autoload.php";

use App\Models\Basedatos;
use App\Models\Clientes;

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../views/clientes_nuevos.php");
    exit;
}

$_SESSION["errores_clientes"] = [];
$todoOk = true;

$nombre    = $_POST["nombre"]    ?? ($todoOk = false);
$telefono  = $_POST["telefono"]  ?? ($todoOk = false);
$direccion = $_POST["direccion"] ?? ($todoOk = false);
$ciudad    = $_POST["ciudad"]    ?? ($todoOk = false);
$cp        = $_POST["cp"]        ?? ($todoOk = false);

// Validaciones básicas
if (!$todoOk) {
    if (!$nombre)    { $_SESSION["errores_clientes"][] = "El nombre es obligatorio."; }
    if (!$telefono)  { $_SESSION["errores_clientes"][] = "El teléfono es obligatorio."; }
    if (!$direccion) { $_SESSION["errores_clientes"][] = "La dirección es obligatoria."; }
    if (!$ciudad)    { $_SESSION["errores_clientes"][] = "La ciudad es obligatoria."; }
    if (!$cp)        { $_SESSION["errores_clientes"][] = "El código postal es obligatorio."; }
    header("Location: ../views/clientes_nuevos.php");
    exit;
}

$nombre    = trim($nombre);
$telefono  = trim($telefono);
$direccion = trim($direccion);
$ciudad    = trim($ciudad);
$cp        = trim($cp);

// Guardamos el cliente
$bd = new Basedatos();
if (!$bd->getConectada()) {
    $_SESSION["errores_clientes"][] = "No hay conexión con la base de datos.";
    header("Location: ../views/clientes_nuevos.php");
    exit;
}

$cliente = new Clientes($nombre, $telefono, $direccion, $ciudad, $cp);
$idNuevo = $bd->crear_cliente($cliente);

if ($idNuevo === null) {
    $_SESSION["errores_clientes"][] = "No se pudo crear el cliente. Inténtalo más tarde.";
    header("Location: ../views/clientes_nuevos.php");
    exit;
}

// Éxito: redirigimos al listado
header("Location: ../views/ver_clientes.php");
exit;
