<!-- guardar($libro): guarda el objeto libro en la bbdd
obtener():$lista_libros: te devuelve una lista con los libros de la bbdd.
existeLibro($titulo):boolean: te indica si el título está ya en la bbdd -->

<?php
function recogerDatos($var){//$var es una variable generica.
    if (isset($_REQUEST[$var]) && $_REQUEST[$var]!="") { // si existe ya sea get o post($_REQUEST) del nombre que le pongamos 
        $campo=trim(htmlspecialchars(strip_tags($_REQUEST[$var])));
        return $campo;
    }
}
return null;

function guardar($libro){
    
}
?>