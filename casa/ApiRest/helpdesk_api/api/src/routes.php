<?php
require __DIR__."/../vendor/autoload.php";
use Api\models\Basedatos;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Api\models\Api_Key;

function manejarRequest($uri,$requestMethod,$headers){

    $mibd=new Basedatos;
    $partes=explode("/",$uri);

    if ($partes[5]!=="api") {
        http_response_code(404);
        echo json_encode(["error"=>"La llamada a la api esta mal formulada"]);
        die;
    }

    switch ($requestMethod) {
        case 'GET':
            http_response_code(200);
            echo json_encode(["mensaje"=>"Estas conectado"]);
            die;
            break;
        
        default:
            http_response_code(404);
            echo json_encode(["error"=>"No existe dicho endPoint"]);
            die;
            break;
    }


}

?>
