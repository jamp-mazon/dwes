<?php
require __DIR__ . "/../../vendor/autoload.php";
use Api\models\Bbdd;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

function usarLog($descripcion,$tipo){
    $log=new Logger("funciones");
    $log->pushHandler(new StreamHandler(__DIR__."/../logs/funciones.log"));
    if ($tipo) {
        $log->info($descripcion);
    }
    else{
        $log->error($descripcion);
    }
}
function comprobarkey($key){
    if ($key===""){
      usarLog("Key vacia en comprobarKey",false);  
      return false;
    }   
    $key_hasheada=hash("sha256",$key);
    $mibd=new Bbdd();
    $sql="SELECT rol FROM api_keys where key_hash=:key_hash";
    $param=[":key_hash"=>$key_hasheada];
    try {
        $sentencia=$mibd->get_data($sql,$param);
        $rol=$sentencia->fetchColumn();
        return $rol;
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(["error"=>"Fallo al verificar la key..."]);
        usarLog("Algo fallo al verificar la key_hashseada",false);
        die;
    }

 
}
?>