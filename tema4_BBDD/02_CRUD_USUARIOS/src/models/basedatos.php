<?php
// require_once "../config.php";
require_once __DIR__ . "/../config.php";//directorio actual mas . para concatenar barra ..(para ir para atras);

class BaseDatos{

    private $conexionPDO;
    private static $instancia;//Singleton patron
    private $dbmotor;
    private $host;
    private $database;
    private $username;
    private $password;

    //Constructor
    private function __construct()
    {
        global $dbMotor;
        global $mysqlHost ;
        global $mysqlUser;
        global $mysqlPassword ;
        global $mysqlDatabase ;

        $this->dbmotor=$dbMotor;
        $this->host=$mysqlHost;
        $this->database=$mysqlDatabase;
        $this->username=$mysqlUser;
        $this->password=$mysqlPassword;

        $dsn_conbbdd = "$this->dbmotor:host=$this->host;dbname=$this->database;charset=utf8mb4";
        $dsn_sinbbdd = "$this->dbmotor:host=$this->host;charset=utf8mb4";

        try {
            //Conecto a una bbdd concreta
            $this->conexionPDO=new PDO($dsn_conbbdd,$this->username,$this->password);
            //echo "<p>Exito en la conexion PDO a la bbdd con PDO</p>";die;
            $this->conexionPDO->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            $this->conexionPDO=null;
            // debug print "<p>ERROR:No puede conectarse con la base de datos!!. {$e->getMessage()}</p>\n";
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

    //Magic method clone is empty to prevent duplication of connection
    private function __clone(){}//prevenir para evitar para crear un duplicado del objeto (bbdd);

    //Metodo para pedirle datos a la bbdd
    public function get_data($sql,array $parametros=[]){//le indico que el segundo parametro sera un array y que puede estar vacio

        try {
            $sentencia=$this->conexionPDO->prepare($sql);
            //
            $sentencia->execute($parametros);//si no esta vacio lo ejecuta y si esta rellena lo ejecuta con los parametros del array asociativo
            return $sentencia;
            
        } catch (PDOException $e) {
            echo "Fallo al realizar la consulta:" .$e->getMessage();
        }
    }


}
?>