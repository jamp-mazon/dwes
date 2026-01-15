<?php
namespace Api\models;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use PDO;
use PDOException;

class Basedatos{
    private PDO $conexionPDO;
    private Logger $log;

    public function __construct()
    {
        $this->log=new Logger("bbdd");
        $this->log->pushHandler(new StreamHandler(__DIR__."/../logs/bbdd.log"));
        $host="127.0.0.1";
        $db_name="helpdesk_api";
        $user="root";
        $pass="";
        $dbMotor="mysql";
        $dsn="$dbMotor:host=$host;dbname=$db_name;charset=utf8mb4";
        try {
            $this->conexionPDO=new PDO($dsn,$user,$pass);
            $this->conexionPDO->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(["Error"=>"Error al conectarse a la BBDD"]);
            $this->log->error("Error al conectarse a la BBDD:($e)");
            die;
        }
    }
    public function getData($sql,$param=[]){

        try {
            $sentencia=$this->conexionPDO->prepare($sql);
            $sentencia->execute($param);
            return $sentencia;
            
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(["Error"=>"No se alojan resultados"]);
            $this->log->error("Error en consulta, vacio o error de syntax:($e)");
            die;
        }
    }
}

?>