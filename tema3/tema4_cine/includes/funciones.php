<?php


function costo_butaca($butacas){
    $contador=0;

    foreach ($_SESSION["butacas"] as $butaca) {
        foreach ($butaca as $valor) {
            if ($valor==1) {
                $contador++;
            }
        }
    }
    $total=$contador*10;
    return $total;
}
?>