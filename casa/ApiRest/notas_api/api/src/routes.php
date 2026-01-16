<?php
require __DIR__ . "/../vendor/autoload.php";

use Api\models\Basedatos;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use DateTimeImmutable;
use Exception;

function manejarRequest($uri, $requestMethod, $headers)
{
    
    $partes = explode("/", $uri);
    $key = $headers["x-Api-key"] ?? "";
    if ($key === "") {
        http_response_code(401);
        echo json_encode(["Error" => "Falta ApiKey..."]);
        die;
    }
    $user_key = comprobarkey($key);
    if (is_null($user_key)) {
        http_response_code(401);
        echo json_encode(["error" => "La key no es correcta..."]);
        die;
    }
    if ($partes[5] !== "api") {
        http_response_code(404);
        echo json_encode(["error" => "No existe dicho endpoint..."]);
        die;
    }

    // Safely obtain the optional ID segment to avoid undefined index notices
    $id = isset($partes[7]) ? urldecode($partes[7]) : "";
    $mibd = new Basedatos();
    switch ($partes[6]) {
        case 'notas':
            if ($id === "") {
                switch ($requestMethod) {
                    case 'GET':
                        $sql = "SELECT * FROM notas";
                        $sentencia = $mibd->get_data($sql);
                        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
                        http_response_code(200);
                        echo json_encode($registro);
                        die;
                        break;

                    default:
                        http_response_code(404);
                        echo json_encode(["error" => "No existe dicho endpoint"]);
                        die;
                        break;
                }
            }
            break;

        default:
            http_response_code(404);
            echo json_encode(["error" => "No existe dicho endpoint"]);
            die;
            break;
    }
}
