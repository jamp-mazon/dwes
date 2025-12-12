<?php 
namespace App\models;
require __DIR__ ."/../../vendor/autoload.php";
use PDO;
use PDOException;
use PDOStatement;

class Basedatos{

    private PDO|null $conexionPDO;
    // private Logger $log;

    public function __construct()
        {
            //Manejador de log
            // $this->log=new Logger("app");
            // $this->log->pushHandler(new StreamHandler(__DIR__. "/../../app.log"));

            $configPath=__DIR__."/../config.json";
            $config= json_decode(file_get_contents($configPath),true);

            $dbmotor=$config["dbMotor"];
            $host=$config["mysqlHost"];
            $user=$config["mysqlUser"];
            $password=$config["mysqlPassword"];
            $database=$config["mysqlDatabase"];

            $dns="$dbmotor:host=$host;dbname=$database;charset=utf8mb4";

            try {
                $this->conexionPDO=new PDO($dns,$user,$password);
                $this->conexionPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                $this->conexionPDO=null;
                // $this->log->error("Fallo al conectarse a la BBDD:".$e->getMessage(),["conexion"=>"basedatos.php"]);
            }
        }
        public function estaConectado(){
            if ($this->conexionPDO==null) {
                return false;
            }
            return true;
        }
        public function get_data($sql,array $parametros=[]):PDOStatement |null{
            try {
            $sentencia = $this->conexionPDO->prepare($sql);
            $sentencia->execute($parametros);
            return $sentencia;
            } catch (PDOException $e) {
                // $this->log->error("Fallo al obtener la tarea:".$e->getMessage(),["recoger_datos"=>"basedatos.php"]);
                return null;

            }
        }

        public function borrar_tarea(Tarea $tarea){
            $sql="DELETE FROM tareas where id=:id";
            try {
                $sentencia=$this->conexionPDO->prepare($sql);
                $sentencia->bindParam(":id",$tarea->id);
                $sentencia->execute();
            } catch (PDOException $e) {
                $this->log->error("Error al borrar la tarea:".$e->getMessage(),["borrado"=>"basedatos.php"]);
            }
        }
        public function actualizar_tarea(Tarea $tarea){
            //update empleado set completado =0 where id=12;
            if ($tarea->completada) {
                $tarea->setCompletada(false);
                $sql="UPDATE tareas set completada = FALSE where id=:id";

            }
            else{
                $tarea->setCompletada(true);
                $sql="UPDATE tareas set completada = TRUE where id=:id";
            }
            // $sql="UPDATE tareas set completada :numero where id=:id";
            try {
                $sentencia=$this->conexionPDO->prepare($sql);
                $sentencia->bindParam(":id",$tarea->id);
                $sentencia->execute();
            } catch (PDOException $e) {
                $this->log->error("Error al cambiar el booleano".$e->getMessage(),["booleano"=>"basedatos.php"]);

            }
        }
}

?>