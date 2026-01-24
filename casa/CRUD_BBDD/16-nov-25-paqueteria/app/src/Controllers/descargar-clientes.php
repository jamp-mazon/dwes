<?php
session_start();
require __DIR__ . "/../../vendor/autoload.php";

use App\Models\Basedatos;

if (!isset($_SESSION['id'])) {
    header('Location: ../public/index.php');
    exit;
}

$bd = new Basedatos();
$sql = "SELECT id, nombre, telefono, direccion, ciudad, cp, creado_en FROM clientes ORDER BY nombre ASC";
$stmt = $bd->get_data($sql, []);
$clientes = $stmt ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];

$html = '<h2>Listado de clientes</h2>';
if (empty($clientes)) {
    $html .= '<p>No hay clientes registrados.</p>';
} else {
    $html .= '<table border="1" cellpadding="6" cellspacing="0" width="100%">';
    $html .= '<thead><tr><th>ID</th><th>Nombre</th><th>Teléfono</th><th>Dirección</th><th>Ciudad</th><th>CP</th><th>Creado en</th></tr></thead><tbody>';
    foreach ($clientes as $c) {
        $html .= '<tr>';
        $html .= '<td>'.htmlspecialchars($c['id']).'</td>';
        $html .= '<td>'.htmlspecialchars($c['nombre']).'</td>';
        $html .= '<td>'.htmlspecialchars($c['telefono'] ?? '').'</td>';
        $html .= '<td>'.htmlspecialchars($c['direccion']).'</td>';
        $html .= '<td>'.htmlspecialchars($c['ciudad']).'</td>';
        $html .= '<td>'.htmlspecialchars($c['cp']).'</td>';
        $html .= '<td>'.htmlspecialchars($c['creado_en']).'</td>';
        $html .= '</tr>';
    }
    $html .= '</tbody></table>';
}

$pdf = new \FPDF('P','mm','A4');
$pdf->AddPage();
$pdf->SetFont('Helvetica','',12);
$pdf->Cell(0,10,utf8_decode('Listado de clientes'),0,1,'C');
$pdf->Ln(5);

// Cabeceras
$pdf->SetFont('Helvetica','B',9);
$pdf->Cell(10,8,'ID',1,0,'C');
$pdf->Cell(45,8,'Nombre',1,0,'C');
$pdf->Cell(25,8,'Telefono',1,0,'C');
$pdf->Cell(50,8,'Direccion',1,0,'C');
$pdf->Cell(30,8,'Ciudad',1,0,'C');
$pdf->Cell(20,8,'CP',1,1,'C');

$pdf->SetFont('Helvetica','',9);
foreach ($clientes as $c) {
    $pdf->Cell(10,7,$c['id'],1,0,'C');
    $pdf->Cell(45,7,utf8_decode($c['nombre']),1,0,'L');
    $pdf->Cell(25,7,utf8_decode($c['telefono'] ?? ''),1,0,'L');
    $pdf->Cell(50,7,utf8_decode($c['direccion']),1,0,'L');
    $pdf->Cell(30,7,utf8_decode($c['ciudad']),1,0,'L');
    $pdf->Cell(20,7,utf8_decode($c['cp']),1,1,'L');
}

$pdf->Output('clientes.pdf', 'D');
exit;
