<?php
session_start();
require __DIR__ . "/../../vendor/autoload.php";

use App\Models\Basedatos;

if (!isset($_SESSION['id'])) {
    header('Location: ../public/index.php');
    exit;
}

$bd = new Basedatos();
$sql = "
    SELECT p.id, p.descripcion, p.estado, p.notas, p.fecha_creacion, p.creado_en, c.nombre AS cliente_nombre
    FROM paquetes p
    JOIN clientes c ON p.id_cliente = c.id
    ORDER BY p.fecha_creacion DESC
";
$stmt = $bd->get_data($sql, []);
$paquetes = $stmt ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];

$pdf = new \FPDF('L', 'mm', 'A4'); // horizontal
$pdf->AddPage();
$pdf->SetFont('Helvetica','',12);
$pdf->Cell(0,10,utf8_decode('Listado de paquetes'),0,1,'C');
$pdf->Ln(5);

// Cabeceras
$pdf->SetFont('Helvetica','B',9);
$pdf->Cell(10,8,'ID',1,0,'C');
$pdf->Cell(40,8,'Cliente',1,0,'C');
$pdf->Cell(60,8,utf8_decode('Descripción'),1,0,'C');
$pdf->Cell(25,8,'Estado',1,0,'C');
$pdf->Cell(60,8,'Notas',1,0,'C');
$pdf->Cell(40,8,utf8_decode('Fecha creación'),1,0,'C');
$pdf->Cell(40,8,utf8_decode('Creado en'),1,1,'C');

$pdf->SetFont('Helvetica','',9);

if (empty($paquetes)) {
    $pdf->Cell(275,10,utf8_decode('No hay paquetes registrados.'),1,1,'C');
} else {
    foreach ($paquetes as $p) {
        $pdf->Cell(10,7,$p['id'],1,0,'C');
        $pdf->Cell(40,7,utf8_decode($p['cliente_nombre']),1,0,'L');
        $pdf->Cell(60,7,utf8_decode($p['descripcion']),1,0,'L');
        $pdf->Cell(25,7,utf8_decode($p['estado']),1,0,'L');
        $pdf->Cell(60,7,utf8_decode($p['notas'] ?? ''),1,0,'L');
        $pdf->Cell(40,7,$p['fecha_creacion'],1,0,'L');
        $pdf->Cell(40,7,$p['creado_en'],1,1,'L');
    }
}

$pdf->Output('paquetes.pdf', 'D');
exit;
