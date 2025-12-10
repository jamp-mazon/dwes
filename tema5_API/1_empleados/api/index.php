<?php
require __DIR__."/vendor/autoload.php";
header("Access-Control-Allow-Origin: *");

header("Content-Type: application/json; charset=UTF-8");
//header("Content-Type: text/plain; charset=UTF-8");

header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$uri=parse_url($_SERVER["REQUEST_URI"],PHP_URL_PATH);//Extraigo solo el path de la URI 
$param =parse_url($_SERVER["REQUEST_URI"],PHP_URL_QUERY);//Extraigo solo los parametros
$requesMethod=$_SERVER["REQUEST_METHOD"];



//PRUEBAS DE RECIBIEMIENTO
// echo $uri;
// echo "\n";
// if ($param=="") {
//     echo "vacio";
// }
// else{
//     echo $param;
// }

// echo "\n";
// echo $requesMethod; 
manejarRequest($uri,$requesMethod,$param);


?>