<?php
require __DIR__. "/../../vendor/autoload.php";

use Api\models\Basededatos;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;


function infoLog($descripcion){
    $log=new Logger("info");
    $log->pushHandler(new StreamHandler(__DIR__."/../logs/info.log"));
    $log->info($descripcion);
}
function errorLog($descripcion){
    $log=new Logger("error");
    $log->pushHandler(new StreamHandler(__DIR__."/../logs/error.log"));
    $log->info($descripcion);    
}

function obtenerRol($keyRecibida){
    $mibd=new Basededatos();
    $sql="SELECT rol from api_keys where key_hash=:key_hash";
    $param=[":key_hash"=>$keyRecibida];
    $sentencia=$mibd->get_data($sql,$param);     
    try {
        $rol=$sentencia->fetchColumn();
        return $rol;
    } catch (PDOException $e) {
        http_response_code(403);
        errorLog("El rol deberia ser invalido o vacio");
        echo json_encode(["error"=>"error al recibir el rol"]);
        die;
    }
}
function obtenerTodos(){
    $mibd=new Basededatos();
    $sql="SELECT * FROM tareas";
    $sentencia=$mibd->get_data($sql);
    try {
        $registro=$sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registro;
    } catch (PDOException $e) {
        http_response_code(500);
        errorLog("Fallo al obtener las tareas en obtenerTodos");
        echo json_encode(["error"=>"Fallo al obtener las tareas"]);
        die;
    }
}
function obtenerPorId($id){
    $mibd=new Basededatos();
    $sql="SELECT * FROM tareas where id=:id";
    $param=[":id"=>$id];
    $sentencia=$mibd->get_data($sql,$param);
    $registro=$sentencia->fetch(PDO::FETCH_ASSOC);
    return $registro;
}
function obtenerPorTitulo($titulo){
    $mibd=new Basededatos();
    $titulo="%$titulo%";
    $sql="SELECT * FROM tareas where titulo LIKE :titulo";
    $param=[":titulo"=>$titulo];
    $sentencia=$mibd->get_data($sql,$param);
    $registro=$sentencia->fetch(PDO::FETCH_ASSOC);
    return $registro;
}
function insertar_tarea($datos){
    $titulo=$datos["titulo"]??"";
    $completada=$datos["completada"]??"";
    if ($titulo==="" || $completada==="") {
        errorLog("La funcion insertar_tarea titulo o completada esta vacio y retorna falso");
        return false;
    }
    $mibd=new Basededatos();
    $sql="INSERT INTO tareas (titulo,completada) VALUES (:titulo,:completada)";
    $param=[":titulo"=>$titulo,":completada"=>$completada];
    $sentencia=$mibd->get_data($sql,$param);
    $datosLog=json_encode($datos,JSON_UNESCAPED_UNICODE);
    infoLog("Insertada con exito: $datosLog");
    return true;
    

}

?>
