<?php
require __DIR__. "/../../vendor/autoload.php";
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

function milog(string $descripcion,bool $tipo){
    $log=new Logger("app");
    $log->pushHandler(new StreamHandler("../../app.log"));
    if ($tipo) {
        $log->info("$descripcion");
    }
    else{
        $log->error("$descripcion");
    }
    return $log;
}

?>