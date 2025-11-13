<?php 
namespace App\models;
require __DIR__ . "/../../vendor/autoload.php";
use PDO;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use PDOException;

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
            return $this->conectado;
        }
        public function conectarBBDD():PDO{
            return $this->conexionPDO;
        }
        public function crear_tarea(Tarea $tarea){

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