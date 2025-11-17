<?php 
namespace App\models;
require __DIR__. "/../../vendor/autoload.php";
use PDO;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use PDOException;
use App\models\Usuarios;

class Basedatos{
    private PDO|null $conexionPDO;
    private Logger $log;
    private bool $conectada;

    public function __construct()
    {
        $this->log=new Logger("app");
        $this->log->pushHandler(new StreamHandler(__DIR__. "/../../app.log"));

        $ruta_config=__DIR__."/../config.json";
        $config_json=json_decode(file_get_contents($ruta_config),true);
        $dbmotor=$config_json["dbMotor"];
        $host=$config_json["mysqlHost"];
        $user=$config_json["mysqlUser"];
        $password=$config_json["mysqlPassword"];
        $database=$config_json["mysqlDatabase"];
        $dsn = "$dbmotor:host=$host;dbname=$database;charset=utf8mb4";

        try {
            $this->conexionPDO = new PDO($dsn, $user, $password);
            $this->conexionPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conectada = true;

        } catch (PDOException $e) {
            $this->log->error("Error al crear el PDO en el contructor de BBDD:".$e->getMessage(),["Contructor"=>"basedatos.php"]);
            $this->conectada=false;
            $this->conexionPDO=null;
        }

    }
    public function get_data($sql,array $parametros=[]){

        try {
            $sentencia=$this->conexionPDO->prepare($sql);
            $sentencia->execute($parametros);
            return $sentencia;            
        } catch (PDOException $e) {
            $this->log->error("Error al hacer la consulta en la BBDD:".$e->getMessage(),["funcion:get_data"=>"basedatos.php"]);
            return null;
        }
        
    }
    //PARTE DE LOS USUARIOS O CONSULTAS EXCLUSIVAS PARA USUARIOS.
    public function existeEmail($email){
        $sql="SELECT * FROM usuarios WHERE email=:email";
        $parametros=[":email"=>$email];
        $sentencia=$this->get_data($sql,$parametros);
        if (!$sentencia) {//sentencia devuelve null por fallo en la conexion.
            $this->log->error("SENTENCIA ES NULL AL COMPROBAR EMAIL");
            return null;
        }
        $registro=$sentencia->fetch(PDO::FETCH_OBJ);
        if ($registro) {//existe el email en la bbdd retorno false
            return false;
        }
        else{//no existe el email con lo cual devuelvo true;
            return true;
        }
    }
    public function crear_usuario(Usuarios $user){
        $sql="INSERT INTO usuarios (nombre, email, password_hash, rol)
        VALUES (:nombre, :email, :password_hash, :rol)";
        try {
            $sentencia=$this->conexionPDO->prepare($sql);
            $sentencia->bindParam(":nombre",$user->getNombre());
            $sentencia->bindParam(":email",$user->getEmail());
            $sentencia->bindParam(":password_hash",$user->getPassword());
            $sentencia->bindParam(":rol",$user->getRol());
            $sentencia->execute();
            return true;            
        } catch (PDOException $e) {
            $this->log->error("Error al crear el usuario en la bbdd:".$e->getMessage(),["crear_usuario"=>"basedatos.php"]);
            return false;
        }
    }


    /**
     * Get the value of log
     */ 
    public function getLog()
    {
        return $this->log;
    }

    /**
     * Get the value of conectada
     */ 
    public function getConectada()
    {
        return $this->conectada;
    }
}

?>