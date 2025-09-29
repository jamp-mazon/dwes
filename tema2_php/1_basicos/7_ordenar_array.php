<?php
$numeros =[3,1,7,2,5];

sort($numeros);//ordena el array rsort (orden decreciente)

foreach ($numeros as $value) {
    echo "$value<br>";
}
print "<pre>";
print_r($numeros);
print "</pre>";

var_dump($numeros);//te indica el contenido y  sus tipos.

?>