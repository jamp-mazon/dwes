<?php
namespace App\models;
use PDO;
use PDOException;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use PDOStatement;
use App\models\incidencias;

class Basedatos{
    private PDO|null $conexionPDO;
    private bool $conectado;

    public function __construct()
    {
        $ruta_path=__DIR__."/../config.json";
        $json=json_decode(file_get_contents($ruta_path));
        $motor=$json->dbMotor;
        $host=$json->mysqlHost;
        $user=$json->mysqlUser;
        $pass=$json->mysqlPassword;
        $database=$json->mysqlDatabase;
        $dsn = "$motor:host=$host;dbname=$database;charset=utf8mb4";
        try {
            $this->conexionPDO=new PDO($dsn,$user,$pass);
            $this->conexionPDO->setAttribute(PDO::ERRMODE_EXCEPTION,PDO::ATTR_ERRMODE);
            $this->conectada=true;
        } catch (PDOException $e) {
            $this->conexionPDO=null;
            $this->conectada=false;
            $log=milog("Error al conectar en la bbdd",false);
        }
        
    }
    public function get_data(string $sql,array $parametros=[]){
        try {
            $sentencia=$this->conexionPDO->prepare($sql);
            $sentencia->execute($parametros);
            return $sentencia;
        } catch (PDOException $e) {
            $log=milog("Error en la consulta de get_data",false);
            return null;
        }
    }
    public function crear_incidencia(incidencias $_incidencia){
        $sql="INSERT INTO incidencias (id,titulo,descripcion,resuelta,id_usuario) VALUES (:id,:titulo,:descripcion,:resuelta,:id_usuario)";
        try {
            $sentencia=$this->conexionPDO->prepare($sql);
            $sentencia->bindParam(":id",$_incidencia->getId());
            $sentencia->bindParam(":titulo",$_incidencia->getTitulo());
            $sentencia->bindParam(":descripcion",$_incidencia->getDescripcion());
            $sentencia->bindParam(":resuelta",$_incidencia->getResuelta());
            $sentencia->bindParam(":id_usuario",$_incidencia->getId_usuario());
            $sentencia->execute();
            $log=milog("Añadido nueva incidencia con titulo:".$_incidencia->getTitulo(),true);
            return true;
        } catch (PDOException $e) {
            $log=milog("Error: Al insertar la incidencia",false);
            return false;
        }
    }
    
}
?>