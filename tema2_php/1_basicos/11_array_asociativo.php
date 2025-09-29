<?php
/*🔹 11. Almacena en un array asociativo los datos de una persona

Parte1 Guarda el nombre, apellidos, edad y email. 
Los datos son Alicia Camacho, de 24 años con email alicia.camacho@gmail.com
Muestra los datos de la persona con una lista sin numerar.
Muestra solo los campos.*/

//creamos el array dato a dato
$persona["nombre"] = "Alicia";
$persona["apellidos"] = "Cano Perez";
$persona["edad"] = 24;
$persona["email"] = "alicia@kk.com";

echo "<pre>";
print_r($persona);
echo "</pre>";

//Datos con una lista
echo "<ul>"; //se hace el ul fuera para que no me repita el origen de la lista 
foreach ($persona as $datos => $valor) {

    echo ("<li>$datos=$valor</li>"); //los li van dentro para que sean los li los que se repitan
}
echo "</ul>";

//Muestro solo los campos
echo "Lista de campos:<br>";
foreach ($persona as $clave => $valor) {
    echo "-$clave<br>";
}
/*Parte2 Crea un array asociativo con la notación => para almacenar edades de personas. 
Los datos son: Andres de 21 años, Barbara de 19 años y Camilo de 15 años Muestra los datos
 con el siguiente codigo y observa: */
 echo "<hr>";
 $edades=["Bárbara"=>21,"Camilo"=>19,"Andrés"=>20];
 echo "<pre>";
 print_r($edades);
 echo"</pre>";
print "<p>Bárbara tiene $edades[Bárbara] años</p>";
print "<p>Camilo tiene {$edades["Camilo"]} años</p>";
print "<p>Andrés tiene " . $edades["Andrés"] . " años</p>";

echo "Hay ".count($edades)." personas<br>";
echo "<ul>";
foreach ($edades as $valor) {
    echo "<li>$valor</li>";
}
echo "</ul>";