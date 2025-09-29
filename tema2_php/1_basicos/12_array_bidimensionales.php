<?php
//ARRAY BIDIMENSIONAL.
$persona["nombre"] = "Alicia";
$persona["apellidos"] = "Cano Perez";
$persona["edad"] = 24;
$persona["email"] = ["alicia@kk.com","alicia@gmail.com"];//el array se ha convertido en bidimensional
//posicion [email][1]
$persona["calificaciones"]=["Programacion"=>8,"Base de datos" =>10,"Sostenibilidad"=>10];
echo "<pre>";
print_r($persona);
echo "</pre>";

echo "<h1>El segundo email es ".$persona["email"][1]."</h1>";
echo "La nota de programacion es:".$persona["calificaciones"]["Programacion"]."<br>";
echo "Lista de Materias:<br>";
foreach ($persona["calificaciones"] as $materia => $nota) {
    echo "$materia----$nota<br>";
}
?>
