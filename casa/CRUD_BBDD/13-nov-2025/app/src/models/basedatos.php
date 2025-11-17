<?php 
namespace App\models;
require __DIR__ . "/../../vendor/autoload.php";
use PDO;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use App\models\Tarea;
use App\models\Usuarios;
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
    public function get_data($sql,array $parametros=[]):PDOStatement|null{
        try {
            $sentencia=$this->conexionPDO->prepare($sql);
            $sentencia->execute($parametros);
            return $sentencia;
        } catch (PDOException $e) {
            throw $e;
            $this->log->error("FALLO AL RECIBIR LOS DATOS:"+$e,["archivo"=>"basedatos.php"]);
            return null;
        }
    }
    public function crear_tarea(Tarea $tarea){
//         INSERT INTO tareas (descripcion, completada, fecha_creacion)
// VALUES ('tarea de prueba', FALSE, '2000-01-01');
            $sql="INSERT INTO tareas (usuario_id,descripcion,completada) VALUES (:usuario_id,:descripcion,:completada)";
            $descripcion=$tarea->getDescripcion();
            $completada=$tarea->getCompletada();
            $id_usuario=$tarea->getId_usuario();
        try {
            $sentencia=$this->conexionPDO->prepare($sql);
            $sentencia->bindParam("usuario_id",$id_usuario);            
            $sentencia->bindParam("descripcion",$descripcion);
            $sentencia->bindParam("completada",$completada);

             $sentencia->execute();
        } catch (PDOException $e) {
            $this->log->error("Fallo al crear la tarea:".$e->getMessage(),["archivo"=>"basedatos.php"]);
        }
    }
    public function borrar_tarea($id){
        $sql="DELETE FROM tareas WHERE id=:id";
        try {
            $sentencia=$this->conexionPDO->prepare($sql);
            $sentencia->bindParam(":id",$id);
            $sentencia->execute();
        } catch (PDOException $e) {
            $this->log->error("Fallo al borrar la tarea:".$e->getMessage(),["borrado"=>"basedatos.php"]);
        }
    }
    public function actualizar_tarea($id,$estado){
        if ($estado) {
            $sql="UPDATE tareas SET completada = FALSE WHERE id=:id";
        }
        else{
            $sql="UPDATE tareas SET completada = TRUE WHERE id=:id";
        }
        try {
            $sentencia=$this->conexionPDO->prepare($sql);
            $sentencia->bindParam(":id",$id);
            $sentencia->execute();
        } catch (PDOException $e) {
            $this->log->error("Error al actualizar la tarea".$e->getMessage(),["actualizar"=>"basedatos.php"]);
        }
    }
    public function crear_usuario(Usuarios $nuevo_usuario){
        $sql="INSERT INTO usuarios(nombre,email,password,fecha_registro) VALUES (:nombre,:email,:password,:fecha_registro)";  
        try {
            $sentencia=$this->conexionPDO->prepare($sql);
            $sentencia->bindParam(":nombre",$nuevo_usuario->getNombre());
            $sentencia->bindParam(":email",$nuevo_usuario->getEmail());
            $sentencia->bindParam(":password",password_hash($nuevo_usuario->getPassword(),PASSWORD_DEFAULT));
            $sentencia->bindParam(":fecha_registro",$nuevo_usuario->getFecha_registro());
            $sentencia->execute();
        } catch (PDOException $e) {
            $this->log->error("Fallo: al insertar el usuario en la BBDD".$e->getMessage(),["crearUsuario"=>"basedatos.php"]);
        }
    }


    /**
     * Get the value of log
     */ 
    public function getLog()
    {
        return $this->log;
    }
}
?>