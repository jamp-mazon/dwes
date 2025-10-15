<?php
session_start();

$nombre=$_SESSION["nombre"];
$edad=$_SESSION["edad"];

unset($_SESSION["nombre"]);
unset($_SESSION["edad"]);

print "Nombre:$nombre <br>";
print "Edad:$edad <br>";

?>
<p><a href="index.php">Volver al formulario index</a></p>