<?php
//los archivos vienen del index.
$partes=explode("/",$uri);
$id=$partes[7]??"";
switch ($partes[6]) {
    case 'mediciones':
        if ($id==="") {
            switch ($requestMethod) {
                case 'GET':
                        $sql="SELECT * FROM mediciones";
                        $sentencia=$mibd->get_data($sql);
                        $registro=$sentencia->fetchAll(PDO::FETCH_ASSOC);
                        if ($registro===[]) {
                            http_response_code(401);
                            $mensaje=["error"=>"No se han encontrado resultados..."];
                            echo json_encode($mensaje);
                            die;
                        }       
                        else{
                            http_response_code(200);
                            echo json_encode($registro);
                            die;
                        }                 
                    break;
                case "POST":
                    if ($apiKey->getRol()==="usuario") {
                        http_response_code(403);
                        echo json_encode(["error"=>"No tienes privilegios para esta operacion..."]);
                        die;
                    }
                    
                    $data=json_decode(file_get_contents("php://input"),true);
                    $sql="INSERT INTO mediciones (ubicacion,fecha,kwh,fuente,observaciones) 
                    values (:ubicacion,:fecha,:kwh,:fuente,:observaciones)";
                    $parametros=[
                        ":ubicacion"=>$data["ubicacion"],
                        ":fecha"=>$data["fecha"],
                        ":kwh"=>$data["kwh"],
                        ":fuente"=>$data["fuente"],
                        ":observaciones"=>$data["observaciones"]
                    ];
                    $sentencia=$mibd->get_data($sql,$parametros);
                    http_response_code(200);
                    echo json_encode(["mensaje"=>"medicion guardada con exito"]);
                    die;
                    break;

                default:
                    http_response_code(404);
                    $mensaje=["error"=>"No existe dicho Endpoint"];
                    echo json_encode($mensaje);
                    die;
                    break;
            }
        }
        else{
            if (!is_numeric($id)) {
                http_response_code(403);
                $mensaje=["error"=>"El mensaje tiene que ser numerico"];
                echo json_encode($mensaje);
            }
            else{
                switch ($requestMethod) {
                    case 'value':
                        # code...
                        break;
                    
                    default:
                        # code...
                        break;
                }
            }
        }
        break;
    
    default:
        http_response_code(404);
        $mensaje=["error"=>"No existe dicho Endpoint"];
        echo json_encode($mensaje);
        die;
        break;
}
?>