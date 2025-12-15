<?php
require __DIR__ ."/../vendor/autoload.php";
use App\models\Basedatos;
function manejarRequest($uri, $requestMethod, $param)
{
    $mibd= new Basedatos();
    if (!$mibd->estaConectado()) {
        //Error de conexion a la bbdd;
        // header("HTTP/1.1 500 Internal server Error") o ;
        http_response_code(500);
        $respuesta= ["error"=>"No es posible conectar a la base de datos"];
        echo json_encode($respuesta);
        die;
    }
    
    $partes = explode("/", $uri);
    //print_r($partes);

    if ($partes[4] !== "api" || $partes[5] !== "empleados") {
        //No existe dicho EndPoint;
        // header("HTTP/1.1 401 Bad Request");
        http_response_code(401);
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
                $sql="SELECT * FROM empleados WHERE id=:id";
                $sentencia=$mibd->get_data($sql,[":id"=>$userId]);
                $registro=$sentencia->fetchAll(PDO::FETCH_ASSOC);
                if ($registro==[]) {
                    http_response_code(404);
                    $mensaje=["error"=>"No existe el objeto con el id $userId"];
                    echo json_encode($mensaje);
                    die;
                }
                http_response_code(200);
                echo json_encode($registro);
                die;
            }
            else{
                $sql="SELECT * FROM empleados";
                $sentencia=$mibd->get_data($sql);
                $registro=$sentencia->fetchAll(PDO::FETCH_ASSOC);
                http_response_code(200);
                echo json_encode($registro);
                die;
            }
            break;

        case 'POST':
                $data=json_decode(file_get_contents("php://input"),true);
                //Añadir datos a la bbdd
                if ($mibd->insertar_usuario($data)) {
                    $respuesta=["mensaje"=>"Usuario Añadido"];
                    http_response_code(201);
                    echo json_encode($respuesta);
                    exit();
                }
                else{
                    $respuesta=["error"=>"El usuario no se ha podido añadir"];

                    http_response_code(500);
                    var_dump($data);
                    echo json_encode($respuesta);
                    exit();
                }

             break;
         case 'DELETE':
             if ($userId!==null && $userId!=="") {
                if ($mibd->borrar_empleados($userId)) {
                    $respuesta=["mensaje"=>"Usuario con ID:$userId ha sido borrado con exito"];
                    http_response_code(200);
                    echo json_encode($respuesta);
                    exit();
                }
                else{
                    $respuesta=["error"=>"Usuario con ID:$userId no se ha podido borrar..."];
                    http_response_code(500);
                    echo json_encode($respuesta);
                    exit();
                }
            }
            else{
                    $respuesta=["error"=>"ID invalido"];
                    http_response_code(500);
                    echo json_encode($respuesta);
                    exit();                
            } 

             break;

        default:
                header("HTTP/1.1 400 BAD REQUEST ");
                $respuesta=["mensaje"=> "No existe el endPoint"];
                echo json_encode($respuesta);
                die;        

            break;
    }
}

?>