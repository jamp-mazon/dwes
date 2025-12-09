<?php
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
$partes=explode("/",$uri);
//print_r($partes);

if ($partes[4]!=="api" || $partes[5]!=="empleados") {
    //No existe dicho EndPoint;
    header("HTTP/1.1 401 Bad Request");
    $respuesta=["mensaje"=>"No existe dicho EndPoint"];
    echo json_encode($respuesta);
}
//Miramos si hemos pedido usuario
$userId=$partes[6] ?? null;
if ($userId==null) {
    echo "No he metido usuario";
    die;
}
// else{
//     echo "He pedido el usuario con id $userId";
// }
//Router analizador de peticion
switch ($requesMethod) {
    case 'GET':
           
        break;
    
    default:

        break;
}

?>