<?php
require __DIR__ . "/vendor/autoload.php";
require __DIR__ . "/src/routes.php";

header("Access-Control-Allow-Origin: *");

header("Content-Type: application/json; charset=UTF-8");
//header("Content-Type: text/plain; charset=UTF-8");

header("Access-Control-Allow-Methods: GET,POST,DELETE");
header("Access-Control-Max-Age: 3400");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$uri=parse_url($_SERVER["REQUEST_URI"],PHP_URL_PATH);
$requestMethod=$_SERVER["REQUEST_METHOD"];
$headers=apache_request_headers();

manejarApi($uri,$requestMethod,$headers);
?>