<?php

//Codigo para leer todo el json de un archivo en una varible
// $datos = [];
// $file = 'nombre_archivo';

// $jsonData = file_get_contents($file, FILE_USE_INCLUDE_PATH);
// $datos = json_decode($jsonData);


function obtenerDatos(){
    $lista_datos=[];
    $ruta="articulos.json";
    $json=file_get_contents($ruta,FILE_USE_INCLUDE_PATH);
    $lista_datos=json_decode($json);
    return $lista_datos;
}
function obtenerArticulo($id_articulo){
    $lista_datos=obtenerDatos();
    foreach ($lista_datos as $articulo) {
        if ($articulo->id==$id_articulo) {
            return $articulo;
        }
    }
    return null;
}

