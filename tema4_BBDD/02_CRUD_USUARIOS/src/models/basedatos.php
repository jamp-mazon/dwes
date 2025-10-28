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

        $dsn_conbbdd = "$this->dbmotor:host $this->host;dbname=$this->database;charset=utf8mb4";
        $dsn_sinbbdd = "$this->dbmotor;:host=$this->host;charset=utf8mb4";

        try {
            //Conecto a una bbdd concreta
            $this->conexionPDO=new PDO($dsn_conbbdd,$this->username,$this->password);
            //echo "<p>Exito en la conexion PDO a la bbdd con PDO</p>"
        } catch (PDOException $e) {
            print "<p>ERROR:No puede conectarse con la base de datos!!. {$e->getMessage()}</p>\n";
        }
        $this->conexionPDO->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
       
    }
    //OBTENEMOS UNA INSTACIA DE LA BASE DE DATOS
    public static function getInstance(){
        if(!self::$instancia)//if no instance then make ob_end_clean
        {
            self::$instancia=new self();
        }
        return self::$instancia;
    }
    


}
?>