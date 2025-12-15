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
        public function insertar_usuario($datos){
// INSERT INTO `empleados` (`nombre`, `direccion`, `salario`) VALUES
// ('Roland Mendel', 'C/ Araquil, 67, Madrid', 5000),
            $sql="INSERT INTO empleados (nombre,direccion,salario) VALUES (:nombre,:direccion,:salario)";
            try {
                $sentencia=$this->conexionPDO->prepare($sql);
                $sentencia->bindParam(":nombre",$datos["nombre"]);
                $sentencia->bindParam(":direccion",$datos["direccion"]);
                $sentencia->bindParam(":salario",$datos["salario"]);
                $sentencia->execute();
                return true;
            } catch (PDOException $e) {
                return false;
            }            
        }

        public function borrar_empleados($id){
            $sql="DELETE FROM empleados where id=:id";
            try {
                $sentencia=$this->conexionPDO->prepare($sql);
                $sentencia->bindParam(":id",$id);
                $sentencia->execute();
                return true;
            } catch (PDOException $e) {
                return false;
            }
        }
        public function actualizar_empleado($id,$datos){
            //update empleado set completado =0 where id=12;
            $sql="UPDATE empleados SET nombre=:nombre,direccion=:direccion,salario=:salario WHERE id=:id";
            try {
                $sentencia=$this->conexionPDO->prepare($sql);
                $sentencia->bindParam(":id",$id);
                $sentencia->bindParam(":nombre",$datos["nombre"]);
                $sentencia->bindParam(":direccion",$datos["direccion"]);
                $sentencia->bindParam(":salario",$datos["salario"]);
                $sentencia->execute();
                return true;
            } catch (PDOException $e) {
                return false;
            }
        }
}

?>