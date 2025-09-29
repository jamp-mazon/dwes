<?php

//---------- depuracion --------

/* 
print "<pre>";
print "Matriz \$_GET" . "<br>";
print_r($_GET);
print "</pre>\n";


print "<pre>";
print "Matriz \$_POST" . "<br>";
print_r($_POST);
print "</pre>\n";


print "<pre>";
print "Matriz \$_REQUEST" . "<br>";
print_r($_REQUEST);
print "</pre>\n";

print "<pre>";
print "Matriz \$_SERVER" . "<br>";
print_r($_SERVER);
print "</pre>\n";


COMENTAR TODO SELECCIONADO CONTROL +K+C
print "<hr>";
*/
//---------- fin depuracion --------

$nombre=$_REQUEST["nombre"];
$edad=$_REQUEST["edad"];

echo "Hola $nombre!! <br>";
echo "Tienes $edad años.<br>";

