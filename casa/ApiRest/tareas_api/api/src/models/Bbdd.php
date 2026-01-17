<?php
namespace Api\models;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use PDO;
use PDOException;

class Bbdd{
    private PDO $conexionPDO;
    private Logger $log;

    public function __construct()
    {
        $this->log= new Logger("bbdd");
        $this->log->pushHandler(new StreamHandler(__DIR__."/../logs/bbdd.log"));
        $host="127.0.0.1";
        $user="root";
        $db_name="tareas_api";
        $pass="";
        $dbMotor="mysql";
        $dsn="$dbMotor:host=$host;dbname=$db_name;charset=utf8mb4";

        try {
            $this->conexionPDO=new PDO($dsn,$user,$pass);
            $this->conexionPDO->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(["error"=>"Fallo al conectar en la bbdd"]);
            $this->log->error("Fallo al conectarse a la bbdd:($e)");
            die;
        }
    }
    public function get_data($sql,$param=[]){
        if ($sql==="") {
            http_response_code(500);
            echo json_encode(["error"=>"Error al conectar a la BBDD"]);
            $this->log->error("El parametro sql en get_data esta vacio");
            die;
        }
        try {
            $sentencia=$this->conexionPDO->prepare($sql);
            $sentencia->execute($param);
            return $sentencia;
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(["error"=>"Error al conectar a la BBDD"]);
            $this->log->error("Fallo en la consulta SQL:($e)");
            die;
        }
    }
}

?>