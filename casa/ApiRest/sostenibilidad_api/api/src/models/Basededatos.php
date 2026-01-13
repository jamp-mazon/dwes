<?php
namespace Api\models;

use PDO;
use PDOException;
use PDOStatement;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class Basededatos{
    private PDO $conexionPDO;
    private Logger $log;    
    private bool $conectado;
    public function __construct()
    {
    // "dbMotor": "mysql",
    // "mysqlHost": "127.0.0.1",
    // "mysqlUser": "root",
    // "mysqlPassword": "",
    // "mysqlDatabase": "gestor_incidencias"
        $this->log = new Logger("bbdd");
        $this->log->pushHandler(new StreamHandler(__DIR__. "/../logs/bbdd.log"));
        $this->conectado=false;
        $dbMotor="mysql";
        $dbHost="127.0.0.1";
        $user="root";
        $pass="";
        $name_database="sostenibilidad_api";

        $dsn="$dbMotor:host=$dbHost;dbname=$name_database;charset=utf8mb4";

        try {
            $this->conexionPDO=new PDO($dsn,$user,$pass);
            $this->conexionPDO->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            $this->conectado=true;
        } catch (PDOException $e) {
            http_response_code(402);
            echo json_encode(["ERROR"=>"Fallo al conectar con la BBDD.($e)"]);
            $this->log->error("Fallo al conectarse a la BBDD:".$e->getMessage(),["conexion"=>"basedatos.php"]);
            exit();
        }
    }
    public function estaConectado(): bool{
        return $this->conectado;
    }
    public function get_data(string $sql,array $param=[]): PDOStatement{
        
        try {
            $sentencia=$this->conexionPDO->prepare($sql);
            $sentencia->execute($param);
            return $sentencia;
        } catch (PDOException $e) {
            $this->log->error("Fallo en la consulta SQL o en los parametros($e)",["ERROR"=>"basededatos.php"]);
            http_response_code(401);
            echo json_encode(["ERROR"=>"Los elementos buscados no se encuentran"]);
            exit();
        }
    }

}
?>
