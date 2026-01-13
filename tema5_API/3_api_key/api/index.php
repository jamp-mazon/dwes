<?php
require_once __DIR__."/includes/funciones.php";
header("Access-Control-Allow-Origin: *");

header("Content-Type: application/json; charset=UTF-8");
//header("Content-Type: text/plain; charset=UTF-8");

header("Access-Control-Allow-Methods: GET,POST,DELETE");
header("Access-Control-Max-Age: 3400");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


$APIKEY = "1234567890";


$uri=parse_url($_SERVER["REQUEST_URI"],PHP_URL_PATH);
$param=parse_url($_SERVER["REQUEST_URI"],PHP_URL_QUERY);
$requestMethod=$_SERVER["REQUEST_METHOD"]; 

//recoger las cabeceras
$headers=apache_request_headers();// un alias: getHeaders()
//===================DEPURACION DE URI , HEADERS Y PARAMS====================================
// print("uri\n");
// print_r($uri);
// print("\n");
// print ("headers\n");
// print_r($headers);
// print("\n");
// print("params\n");
// print_r($param);
//=============================================================================================

$keyRecibida=$headers["x-API-key"]??"";

//necesito saber el rol de la key que estoy recibiendo

$rol=obtener_rol($keyRecibida);

if (!$rol) {
    http_response_code(401);
    echo json_encode(["error"=>"Api Key no válida"]);
    exit();
}
// else{
//     // http_response_code(200);
//     // echo json_encode(["Conectado"=>$rol]);
//     // exit();

// }
$partes=explode("/",$uri);

if ($partes[4]!=="api" || $partes[5]!=="libros") {
    http_response_code(400);
    $respuesta=["mensaje"=>"No existe el endpoint"];
    echo json_encode($respuesta);
    exit();
}
$titulo=urldecode($partes[6])??null;//urldecode te permite tener respuesta con espacios. sin que salga el %20

switch ($requestMethod) {
    case 'GET':
        //endpoint GET /api/libros/
        if (is_null($titulo)) {
            $libros=obtener_libros();
            http_response_code(200);
            echo json_encode($libros);
            die;
        }
        else{
            // endpoint get /api/libros/titulo
            $libro=obtener_libro_titulo($titulo);
            http_response_code(201);
            echo json_encode($libro);
            die;
        }
        break;
    case "POST":
        if ($rol==="ADMIN") {
            //endpoint post /api/libros
            $datos=json_decode(file_get_contents("php://input"),true);
            if (insertarLibro($datos)) {
                http_response_code(201);
                echo json_encode(["mensaje"=>"Libro insertado con exito"]);
                exit();
            }
            else{
                http_response_code(400);
                echo json_encode(["error"=>"Fallo al insertar el libro"]);
                exit();
            }
        }
        else{
            http_response_code(401);
            $mensaje=["error"=>"No tiene privilegios..."];
            echo json_encode($mensaje);
            die;
        }
    case "DELETE":
        if ($rol==="ADMIN") {
            $datos= json_decode(file_get_contents("php://input"),true);
            if (eliminarLibro($datos)) {
                http_response_code(201);
                $mensaje=["mensaje"=>"Libro borrado con exito"];
                echo json_encode($mensaje);
                die;
            }
            else{
                http_response_code(500);
                $mensaje=["error"=>"No se pudo eliminar el libro"];
                echo json_encode($mensaje);
                die;
            }
        } 
        else{
            http_response_code(401);
            $mensaje=["error"=>"No tienes privilegios"];
            echo json_encode($mensaje);
            die;
        }
    
    default:
        # code...
        break;
}



// $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); //estraigo solo el path de la URI
// $param = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY); //estraigo solo los parametros
// $requestMethod = $_SERVER["REQUEST_METHOD"];

// $headers = apache_request_headers(); //un alias: getallheaders()


// // echo ($uri);echo ("\n");
// // echo ($param);echo ("\n");
// // echo ($requestMethod);echo ("\n");
// // echo ("\n");
// // echo ("\n");


// // foreach ($headers as $header => $value) {
// //     echo "$header: $value \n";
// // }

// // die;


// $keyUsuarui = $headers["Authorization"] ?? "";


// if ($APIKEY !== $keyUsuarui) {
//     http_response_code(401);
//     echo json_encode([
//         "error" => "API Key no válida"
//     ]);
//     exit;
// }else{
//     http_response_code(200);
//     echo json_encode([
//         "mensaje" => "API Key válida"
//     ]);
//     exit;