<?php
//Archivos para incluir funciones que seran llamadas posteriormentefunction devolverMayor(array $miArray):int{

function devolverMayor(array $miArray):int{

    $num=$miArray[0];
    foreach ($miArray as $numero) {
        if ($numero>$num) {
            $num=$numero;
        }
    }
    return $num;
}
function mayor_numero(array $miArray):int{
    
    $num=$miArray[0];
    foreach ($miArray as $numero) {
        //Compruebo primero que es un numero . Si no excepcion
        if(!is_integer($numero)){//si numero no es entero....
            throw new Exception("ERROR:$numero no es un numero entero");
            
        }

        if ($numero>$num) {
            $num=$numero;
        }
    }
    return $num;
}
?>