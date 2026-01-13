<?php
session_start();
require __DIR__ . "/../vendor/autoload.php";
use Api\models\Basededatos;
use Api\models\api_key;
use DateTimeImmutable;

header("Access-Control-Allow-Origin: *");

header("Content-Type: application/json; charset=UTF-8");
//header("Content-Type: text/plain; charset=UTF-8");

header("Access-Control-Allow-Methods: GET,POST,DELETE");
header("Access-Control-Max-Age: 3400");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


$uri=parse_url($_SERVER["REQUEST_URI"],PHP_URL_PATH);
$param=parse_url($_SERVER["REQUEST_URI"],PHP_URL_QUERY);
$requestMethod=$_SERVER["REQUEST_METHOD"];

$headers=apache_request_headers();// un alias: getHeaders()
$key=$headers["x-api-key"] ?? $headers["x-Api-key"] ?? $headers["X-Api-Key"] ?? "";
if (!$key) {
    http_response_code(401);
    echo json_encode(["error"=>"Api Key requerida"]);
    die;
}

//Primero comprobamos si podemos conectarnos a la bbdd
$mibd=new Basededatos();
if ($mibd->estaConectado()) {
    $sql="SELECT * FROM api_keys WHERE key_hash=:key_hash";
    $sentencia=$mibd->get_data($sql,["key_hash"=>hash("sha256",$key)]);
    $registro=$sentencia->fetch(PDO::FETCH_ASSOC);
    if (!$registro) {
        http_response_code(403);
        echo json_encode(["error"=>"Key incorrecta..."]);
        die;
    }
    $apiKey=new api_key(
        $registro["key_hash"],
        $registro["rol"],
        (bool)$registro["activa"],
        new DateTimeImmutable($registro["creada_en"])
    );
    $ahora=new DateTimeImmutable();
    if ($apiKey->estaCaducada($ahora)){
        http_response_code(403);
        echo json_encode(["error"=>"Key caducada o en desuso"]);
        die;
    }
    // Ruteo de la API. $apiKey disponible para controladores.
    require __DIR__ . "/../src/routes.php";
}
else{
    http_response_code(500);
    echo json_encode(["error"=>"Error de conexion"]);
    die;
}
?>
