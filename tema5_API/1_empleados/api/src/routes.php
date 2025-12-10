<?php

function manejarRequest($uri, $requestMethod, $param)
{
    $partes = explode("/", $uri);
    //print_r($partes);

    if ($partes[4] !== "api" || $partes[5] !== "empleados") {
        //No existe dicho EndPoint;
        header("HTTP/1.1 401 Bad Request");
        $respuesta = ["mensaje" => "No existe dicho EndPoint"];
        echo json_encode($respuesta);
        die;
    }
    //Miramos si hemos pedido usuario
    $userId = $partes[6] ?? null;
    //Router analizador de peticion
    switch ($requestMethod) {
        case 'GET':
            //endpoint /api/empleados/X
            if ($userId!==null && $userId!=="") {
                header("HTTP/1.1 200 OK");
                $respuesta=["mensaje"=> "Mando al empleado $userId"];
                echo json_encode($respuesta);
                die;
            }
            else{
                header("HTTP/1.1 200 OK");
                $respuesta = ["mensaje" => "Mando a todos los empleados"];
                echo json_encode($respuesta);
                die;
            }
            break;

        // case 'POST':

        //     break;
        // case 'PUT':

        //     break;
        // case 'DELETE':

        //     break;

        default:
                header("HTTP/1.1 400 BAD REQUEST ");
                $respuesta=["mensaje"=> "No existe el endPoint"];
                echo json_encode($respuesta);
                die;        

            break;
    }
}

?>