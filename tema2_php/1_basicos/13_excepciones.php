<?php

function dividir($num1,$num2){
    if ($num2==0) {
        throw new Exception("Error :Division por cero");
        //return null;
    }
    return $num1/$num2;    
    
}

$x=5;
$y=0;
try {
echo "$x dividido entre $y es ".number_format(dividir($x,$y),2);//primero le das el numero y luego le indicas los decimales
//Nos creamos una excepcion y capturamos el error.    
} catch (Exception $error) {
    echo ($error->getMessage());
}


//------------------------------------------------------
echo"<hr>";
require_once("funciones/utilidades.php");
$lista=[2,5,8,"pepe",13];
try {
    echo "El mayor es:".mayor_numero($lista)."<br>";
} catch (Exception $e) {
    
    echo ($e->getMessage());
}



?>