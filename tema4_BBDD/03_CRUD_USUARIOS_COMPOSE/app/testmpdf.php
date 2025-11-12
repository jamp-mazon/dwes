<?php
require_once __DIR__ . '/vendor/autoload.php';

use Mpdf\Mpdf;

// $mpdf = new \Mpdf\Mpdf();
$mpdf= new Mpdf();
$lista=["Alicia","Guillermo","Arancha"];
$mpdf->WriteHTML('<h1>Lista Nombres!</h1>');
foreach ($lista as $elemento) {
    $mpdf->WriteHTML("<p>-$elemento</p>");
}
$mpdf->WriteHTML('<h1>Hello world!</h1>');
$mpdf->Output();


//composer require mpdf/mpdf:^8.2 -w
?>