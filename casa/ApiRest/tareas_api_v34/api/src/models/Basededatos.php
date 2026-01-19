<?php

namespace Api\models;

require __DIR__. "/../../vendor/autoload.php";
use PDO;
use PDOException;

class Basededatos{
    private PDO $conexionPDO;

    public function __construct()
    {
        $host="127.0.0.1";
        $db_name="tareas_api";
        $motor="mysql";
        $user="root";
        $pass="";
        $dsn="$motor:host=$host;dbname=$db_name;charset=utf8mb4";

        try {
            $this->conexionPDO=new PDO($dsn,$user,$pass);
            $this->conexionPDO->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $e) {
            http_response_code(500);
            errorLog("Error en el constructor de basedatos:($e)");
            echo json_encode(["error"=>"Error al conectar a la BBDD"]);
            die;
        }
    }

    public function get_data($sql,$param=[]){
        if ($sql==="") {
            errorLog("SQL en get_data esta vacio");
            return null;
        }
        try {
        $sentencia=$this->conexionPDO->prepare($sql);
        $sentencia->execute($param);
        return $sentencia;
        } catch (PDOException $e) {
            http_response_code(500);
            errorLog("get_data da un fallo al hacer la sentencia o al retornarla");
            echo json_encode(["error"=>"Fallo en la conexion a la bbdd"]);
            die;
        }
    }

}

?>