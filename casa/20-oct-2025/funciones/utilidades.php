<?php
function generarIdPersistente() {
    static $contador = null;
    $ruta = 'bbdd/peliculas.json';

    if ($contador === null) {
        $pelis = file_exists($ruta) ? json_decode(file_get_contents($ruta), true) : [];
        $contador = 0;
        foreach ($pelis as $p) {
            if ($p['id'] > $contador) $contador = $p['id'];
        }
    }

    $contador++;
    return $contador;
}
?>