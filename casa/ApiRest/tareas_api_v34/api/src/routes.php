<?php

require __DIR__ . "/../vendor/autoload.php";


function manejadordeApi($uri,$metodoRequest,$headers){
    
    $keyRecibida=$headers["x-api-key"]??"";
    if ($keyRecibida=="") {
        http_response_code(403);
        errorLog("Usuario intenta acceder sin key o se recibe vacia");
        echo json_encode(["error"=>"ApiKey vacia..."]);
        die;
    }
    $key_hasheada=hash("sha256",$keyRecibida);   
    $rol=obtenerRol($key_hasheada);
     
    if (!$rol) {
        http_response_code(403);
        errorLog("El rol da false con lo cual la key es invalida");
        echo json_encode(["error"=>"Rol invalido"]);
        die;
    }
    $partes=explode("/",$uri);
    if ($partes[4]!=="tareas_api_v34" || $partes[5]!=="api"|| $partes[6]!=="tareas") {
        http_response_code(404);
        errorLog("El usuario esta usando un endpoint invalido");
        echo json_encode(["error"=>"No existe dicho endpoint"]);
        die;
    }
    $parametro=$partes[7]??"";
    $parametro=urldecode($parametro);

    switch ($metodoRequest) {
        case 'GET':
                if ($parametro=="") {
                    $registro=obtenerTodos();
                    http_response_code(200);
                    infoLog("$rol:Uso el metodo get obtener todos satisfactoriamente");
                    echo json_encode($registro);
                    die;
                }
                else{
                    if (is_numeric($parametro)) {
                        $registro=obtenerPorId($parametro);
                        http_response_code(200);
                        infoLog("$rol:Uso el metodo get para obtener por ID");
                        echo json_encode($registro);
                        die;
                    }
                    else{
                        $registro=obtenerPorTitulo($parametro);

                        if ($registro===false) {
                            http_response_code(401);
                            errorLog("No se encontro el registro al obtenerPorTitulo");
                            echo json_encode(["error"=>"Tarea no encontrada..."]);
                            die;
                        }

                        http_response_code(200);
                        infoLog("$rol:Uso el metodo get para obtener por titulo");
                        echo json_encode($registro);
                        die;                        
                    }
                }
            break;
        case "POST":
            if ($rol==="admin") {
                $datos=json_decode(file_get_contents("php://input"),true);
                
                if (insertar_tarea($datos)) {
                    http_response_code(201);
                    echo json_encode(["mensaje"=>"Tarea insertada con exito"]);
                    die;
                }
                else{
                    http_response_code(405);
                    errorLog("No se pudo insertar en la bbdd: ".json_encode($datos,JSON_UNESCAPED_UNICODE));
                    echo json_encode(["error"=>"Fallo al insertar la tarea"]);
                    die;
                }
            }
            else{
                http_response_code(403);
                errorLog("$rol:No tiene permisos para hacer post");
                echo json_encode(["error"=>"No tiene permisos suficientes"]);
                die;
            }
            break;
        
        default:
            # code...
            break;
    }
}
?>
