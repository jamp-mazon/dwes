<?php 
require __DIR__ ."/../../vendor/autoload.php";
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
function nombre_dado_id(){
    
}
//Funcion para meter mensajes en el log
//Enviar_log("Mensaje de error",error)
//enviar_log("mensaje de info",info)
function enviar_log($mensaje,$tipo){
    $log=new Logger("app");
    $log->pushHandler(new StreamHandler(__DIR__ . "/../../app.log"));

    if ($tipo==="error") {
        $log->error($mensaje);
    }
    elseif ($tipo==="info") {
        $log->info($mensaje);
    }
    
}


