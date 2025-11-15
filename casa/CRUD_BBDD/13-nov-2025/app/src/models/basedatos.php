<?php 
namespace App\models;
require __DIR__ . "/../../vendor/autoload.php";
use PDO;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use App\models\Tarea;
use PDOException;
use PDOStatement;

class Basedatos{

    private PDO|null $conexionPDO;
    private Logger $log;
    private bool $conectado;

    public function __construct()
    {
            $this->log=new Logger("app");
            $this->log->pushHandler(new StreamHandler(__DIR__. "/../../app.log"));
            $config_path=__DIR__."/../config.json";
            $config=json_decode(file_get_contents($config_path),true);
            $dbmotor=$config["dbMotor"];
            $host=$config["mysqlHost"];
            $user=$config["mysqlUser"];
            $password=$config["mysqlPassword"];
            $database=$config["mysqlDatabase"];

            $dsn_conbbdd = "$dbmotor:host=$host;dbname=$database;charset=utf8mb4";

            try {
                $this->conexionPDO=new PDO($dsn_conbbdd,$user,$password);
                $this->conexionPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->conectado=true;
            } catch (\PDOException  $e) {
                $this->conectado=false;
                $this->conexionPDO=null;
                $this->log->error("FALLO AL CONECTAR BASE DE DATOS:"+$e,["archivo"=>"basedatos.php"]);
            }   
    }
    // public function conectarse():PDO{
    //     return $this->conexionPDO;
    // }
    public function estaConectado(){
        return $this->conectado;
    }
    public function get_data($sql,array $parametros=[]):PDOStatement{
        try {
            $sentencia=$this->conexionPDO->prepare($sql);
            $sentencia->execute($parametros);
            return $sentencia;
        } catch (PDOException $e) {
            throw $e;
            $this->log->error("FALLO AL RECIBIR LOS DATOS:"+$e,["archivo"=>"basedatos.php"]);
        }
    }
    public function crear_tarea(Tarea $tarea){
//         INSERT INTO tareas (descripcion, completada, fecha_creacion)
// VALUES ('tarea de prueba', FALSE, '2000-01-01');
            $sql="INSERT INTO tareas (descripcion,completada) VALUES (:descripcion,:completada)";
            $descripcion=$tarea->getDescripcion();
            $completada=$tarea->getCompletada();
        try {
            $sentencia=$this->conexionPDO->prepare($sql);
            $sentencia->bindParam("descripcion",$descripcion);
            $sentencia->bindParam("completada",$completada);
            return $sentencia->execute();
        } catch (PDOException $e) {
            $this->log->error("Fallo al crear la tarea:"+$e,["archivo"=>"basedatos.php"]);
        }
    }

}
?>