<?php
require __DIR__ . "/vendor/autoload.php";


use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$log= new Logger("app");
$log->pushHandler(new StreamHandler("app.log"));
$log->error("Error generico");

$log->error("Error generico",["archivo"=>"testmonolog.php"]);

$nombre="Pedro";
$log->debug("Debug:$nombre");

$log->debug("Debug:$nombre");





?>