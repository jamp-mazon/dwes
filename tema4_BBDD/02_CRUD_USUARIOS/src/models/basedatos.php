<?php
// require_once "../config.php";
require_once __DIR__ . "/../config.php";//directorio actual mas . para concatenar barra ..(para ir para atras);

class BaseDatos{

    private PDO| null $conexionPDO;
    private static $instancia;//Singleton patron
    private string $dbmotor;
    private string $host;
    private string $database;
    private string $username;
    private string $password;

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
    public function crear_usuario(Usuario $_usuario){
        $nombre = $_usuario->nombre;
        $apellidos = $_usuario->apellidos;
        $usuario = $_usuario->usuario;
        $password = $_usuario->password;
        $fecha_nac = $_usuario->fecha_nac->format("Y-m-d");

         $sql="INSERT INTO usuarios (nombre,apellidos,usuario,password,fecha_nac)
         VALUES(:nombre,:apellidos,:usuario,:password,:fecha_nac)";

         try {
            $sentencia = $this->conexionPDO->prepare($sql);
            $sentencia -> bindParam(":nombre",$nombre);
            $sentencia -> bindParam(":apellidos",$apellidos);
            $sentencia -> bindParam(":usuario",$usuario);
            $sentencia -> bindParam(":password",$password);
            $sentencia -> bindParam(":fecha_nac",$fecha_nac);
            $sentencia -> execute();
             return true;
        }
        catch(PDOException $e){
            echo $e->getMessage();
            return false;
            //die;
        }
    }
    public function borrar_usuario(int $id){
        $sql="DELETE FROM usuarios where id=:id";

        try {
             $sentencia=$this->conexionPDO->prepare($sql);
             $sentencia->bindParam(":id",$id);
             $sentencia->execute();
             return true;

        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
    public function actualizar_usuario(Usuario $_usuario){
        $id=$_usuario->id;
        $nombre=$_usuario->nombre;
        $apellidos=$_usuario->apellidos;
        $user=$_usuario->usuario;
        $fecha_nac=$_usuario->fecha_nac;
        $password=$_usuario->password;
        if (is_null($password)) {
           $sql="UPDATE usuarios
                     SET    nombre = :nombre,
                            apellidos = :apellidos,
                            usuario = :usuario,
                            fecha_nac = :fecha_nac
                    WHERE id = :id";
        }
        else{
            $sql= "UPDATE usuarios 
            SET nombre=:nombre,apellidos=:apellidos,usuario=usuario,password=:password,fecha_nac=:fecha_nac,
            WHERE id=:id";
        }
        try {
             $sentencia=$this->conexionPDO->prepare($sql);
            $sentencia->bindParam(":nombre",$nombre);
            $sentencia->bindParam(":apellidos",$apellidos);
            $sentencia->bindParam(":usuario",$usuario);
            if (!is_null($password)) {
                $sentencia->bindParam(":password",$password);
            }
            $sentencia->bindParam(":fecha_nac",$fecha_nac);
            $sentencia->execute();
            return true;

        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }

    }


}
?>