<?php
$contenido = file_get_contents("usuarios.json");
$datos = json_decode($contenido, true);

echo "<pre>";
echo "Estructura completa:\n";
var_dump($datos); // nivel 1
echo "\n-------------------------------------------------\n";

echo "Nivel 1 → tipo de datos:\n";
var_dump(gettype($datos)); // array asociativo con la clave 'usuarios'
echo "\n-------------------------------------------------\n";

$usuarios = $datos["usuarios"];
echo "Nivel 2 → tipo de datos (usuarios):\n";
var_dump(gettype($usuarios)); // array indexado
echo "\n-------------------------------------------------\n";

echo "Primer usuario dentro del array:\n";
var_dump($usuarios[0]); // array asociativo de claves id, nombre, edad, email
echo "\n-------------------------------------------------\n";

echo "Tipo de primer usuario:\n";
var_dump(gettype($usuarios[0]));
echo "</pre>";