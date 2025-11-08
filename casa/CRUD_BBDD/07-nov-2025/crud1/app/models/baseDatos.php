<?php
require_once __DIR__."/../config.php";

class BaseDatos{
    private PDO|null $conexionPDO;
    private static $instancia;
    private string $dbmotor;
    private string $host;
    private string $database;
    private string $username;
    private string $password;
    //Constructor privado , luego haremos que se llame a si mismo para que por lo menos se pueda construir una unica vez;
    private function __construct()
    {
        global $dbMotor;
        global $mysqlHost;
        global $mysqlUser;
        global $mysqlPassword;
        global $mysqlDatabase;

        $this->dbmotor=$dbMotor;
        $this->host=$mysqlHost;
        $this->database=$mysqlDatabase;
        $this->username=$mysqlUser;
        $this->password=$mysqlPassword;

        $dsn="$this->dbmotor:host=$this->host;dbname=$this->database;charset=utf8mb4";

        try {
            $this->conexionPDO=new PDO($dsn,$this->username,$this->password);
            // echo "Conexion realizada con exito!!";
            $this->conexionPDO->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $e) {
            // echo "La conexión ha fallado...".$e->getMessage();
        }
    }
    //OBTENEMOS UNA INSTACIA DE LA BASE DE DATOS
    public static function getInstance(){
        if(!self::$instancia)//if no instance then make ob_end_clean
        {
            self::$instancia=new self();
        }
        return self::$instancia;
    }
    public function getConnection(){
        return $this->conexionPDO;
    }
    public function get_data($sql,array $parametros=[]){
        try {
           $sentencia=$this->conexionPDO->prepare($sql);
           $sentencia->execute($parametros);
           return $sentencia;
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }    
}

?>