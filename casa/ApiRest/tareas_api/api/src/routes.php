<?php
require __DIR__ ."/../vendor/autoload.php";
use Api\models\Bbdd;

function manejarApi($uri,$requestMethod,$headers){
    $api_key=$headers["x-api-key"]??"";
    if ($api_key=="") {
        http_response_code(401);
        echo json_encode(["error"=>"Falta la autorizacion ApiKey..."]);
        die;
    }
    $rol=comprobarkey($api_key);
    if (!$rol) {
        http_response_code(403);
        // var_dump($api_key);
        // die;        
        echo json_encode(["error"=>"Algo fallo al comprobar la key"]);
        die;
        
    }
    $partes=explode("/",$uri);
    if ($partes[5]!=="api") {
        http_response_code(404);
        echo json_encode(["error"=>"No existe dicho Endpoint"]);
        die;
    }
    $parametro=urldecode($partes[7])??"";
    $mibd=new Bbdd();
    switch ($partes[6]) {
        case 'tareas':
            if ($parametro==="") {
                switch ($requestMethod) {
                    case 'GET':
                        $sql="SELECT * FROM tareas";
                        $sentencia=$mibd->get_data($sql);
                        $registro=$sentencia->fetchAll(PDO::FETCH_ASSOC);
                        http_response_code(200);
                        echo json_encode($registro);
                        die;
                        break;
                    case "POST":
                        if ($rol==="admin") {
                            $datos=json_decode(file_get_contents("php://input"),true);
                            $sql="INSERT INTO tareas (titulo, completada) VALUES (:titulo, :completada)";
                            $param=[":titulo"=>$datos["titulo"],":completada"=>$datos["completada"]];
                            $mibd->get_data($sql,$param);
                            http_response_code(200);
                            echo json_encode(["mensaje"=>"Tarea insertada con exito"]);
                            die;
                        }
                        else{
                            http_response_code(403);
                            echo json_encode(["error"=>"No tienes permisos para hacer esta operacion"]);
                        }
                    
                    default:
                        http_response_code(404);
                        echo json_encode(["error"=>"No existe dicho Endpoint"]);
                        die;
                        break;
                }
            }
            else{
                if (is_numeric($parametro)) {
                switch ($requestMethod) {
                    case 'GET':
                        $sql="SELECT * FROM tareas where id=:id";
                        $sentencia=$mibd->get_data($sql,[":id"=>$parametro]);
                        $registro=$sentencia->fetch(PDO::FETCH_ASSOC);
                        http_response_code(200);
                        echo json_encode($registro);
                        die;
                        break;
                    case "DELETE":
                        $sql="DELETE FROM tareas where id=:id";
                        $mibd->get_data($sql,[":id"=>$parametro]);
                        http_response_code(200);
                        echo json_encode(["mensaje"=>"Tarea eliminada con exito"]);    
                    default:
                            http_response_code(404);
                            echo json_encode(["error"=>"No existe dicho Endpoint"]);
                            die;
                        break;
                }
                }
            }
            break;
        
        default:
            http_response_code(404);
            echo json_encode(["error"=>"No existe dicho Endpoint"]);
            die;            
            break;
    }
}

?>