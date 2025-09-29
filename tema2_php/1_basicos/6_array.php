<?php
$miArray=array("Pepe","Manolo","Eustaquio","Rodolfo");

for ($i=0; $i < count($miArray); $i++) { 
    echo "$i es $miArray[$i]<br>";
}
echo "------------------------------------------<br>";

foreach ($miArray as $indice => $nombre) {
    echo "$indice es $nombre <br>";
}
echo "--------------<br>";
//creamos array vacio y le añadimos valores
$lista= [];
$lista[]=34;
$lista[]="hola";

echo "$lista[0]";

foreach ($lista as  $value) {
    echo "$value<br>";
}
?>