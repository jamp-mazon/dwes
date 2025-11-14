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
            //Manejador de log
            $this->log=new Logger("app");
            $this->log->pushHandler(new StreamHandler(__DIR__. "/../../app.log"));

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
                $this->conectado=true;
            } catch (PDOException $e) {
                $this->conexionPDO=null;
                $this->conectado=false;
                $this->log->error("Fallo al conectarse a la BBDD:".$e->getMessage(),["conexion"=>"basedatos.php"]);
                
            }
        }
        public function estaConectado(){
            $_SESSION["conectado"]=true;
            return $this->conectado;
        }
        public function get_data($sql,array $parametros=[]):PDOStatement |null{
            try {
            $sentencia = $this->conexionPDO->prepare($sql);
            $sentencia->execute($parametros);
            return $sentencia;
            } catch (PDOException $e) {
                $this->log->error("Fallo al obtener la tarea:".$e->getMessage(),["recoger_datos"=>"basedatos.php"]);

            }
        }
        public function crear_tarea(Tarea $tarea){
//             INSERT INTO tareas (descripcion, completada, fecha_creacion)
// VALUES ('tarea de prueba', FALSE, '2000-01-01');
            $sql="INSERT INTO tareas (descripcion,completada) VALUES (:descripcion,:completada)";
            try {
            $sentencia = $this->conexionPDO->prepare($sql);
            $sentencia->bindParam(":descripcion", $tarea->getDescripcion());
            $sentencia->bindParam(":completada", $tarea->getCompletada());
            $sentencia->execute();
            return $sentencia;
            } catch (PDOException $e) {
                $this->log->error("Fallo al crear la tarea:".$e->getMessage(),["creacion"=>"basedatos.php"]);
                return null;
            }
        }

        public function borrar_tarea($id){
            $sql="DELETE FROM tareas where :id";
            $sentencia=$this->conexionPDO->prepare($sql);
            $sentencia->bindParam(":id",$id);
            $sentencia->execute();
        }
        

    /**
     * Get the value of conectado
     */ 
    public function getConectado()
    {
        return $this->conectado;
    }
}

?>