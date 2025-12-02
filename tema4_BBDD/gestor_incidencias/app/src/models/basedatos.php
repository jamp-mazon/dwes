<?php

//=============== AYUDA =====================================
        //--------------cargar json a array asociativo
        //ARRAY_ASOCIATIVO = json_decode(file_get_contents(RUTA), true);
        

        //------------- Para conectar
        //DSN = "mysql:dbname=test;host=127.0.0.1;charset=utf8mb4"
        
        //CONEXION = new PDO(DSN, USUARIO, PASSWORD);
        //CONEXION->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //Las excepciones se recogen con (PDOException $e) Y para ver el mensaje
        //tenemos el método "getMessage()"

        // -------- ejecutar consultas
        
        // sentencia = conexionPDO->prepare(CADENA CON LA CONSULTAD SQL);
        
        // OPCION1
        // sentencia -> bindParam(":ETIQUETA",VALOR);
        // sentencia -> execute();

        // OPCION2
         // sentencia -> execute([":ETIQUETA" => VALOR, ":ETIQUETA" => VALOR, ... ]);


//=============== AYUDA =====================================

namespace App\models;
use PDO;
use PDOException;
use PDOStatement;

class Basedatos

{
    private PDO|null $conexionPDO;
    
    public function __construct()
    {
        $rutaPath=__DIR__."/../config/config.json";
        $config_json=json_decode(file_get_contents($rutaPath), true);

        $dbMotor=$config_json["dbMotor"];
        $mysqlHost=$config_json["mysqlHost"];
        $mysqlUser=$config_json["mysqlUser"];
        $mysqlPassword=$config_json["mysqlPassword"];
        $mysqlDatabase=$config_json["mysqlDatabase"];
              //------------- Para conectar
        $dsn= "$dbMotor:dbname=$mysqlDatabase;host=$mysqlHost;charset=utf8mb4";
        
        try {
            $this->conexionPDO=new PDO($dsn,$mysqlUser,$mysqlPassword);
            $this->conexionPDO->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $e) {
            $this->conexionPDO=null;
            enviar_log("Error al conectar a la BBDD:".$e->getMessage(),"error");
            die;
        }
        //CONEXION = new PDO(DSN, USUARIO, PASSWORD);
        //CONEXION->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
              
    }//fin constructor
    /**
     * Get the value of conexionPDO
     */ 
    public function getConexionPDO()
    {
        return $this->conexionPDO;
    }
    public function get_data(string $sql,array $parametros=[]):PDOStatement|null {
        try {
            $sentencia=$this->conexionPDO->prepare($sql);
            $sentencia->execute($parametros);
            return $sentencia;
        } catch (PDOException $e) {
            enviar_log("Error en la consulta:".$e->getMessage(),"error");
            return null;
        }
    }
    
} //fin clase


