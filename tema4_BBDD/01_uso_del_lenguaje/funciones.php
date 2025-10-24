<?php
include_once "config.php";
//Funcion que me devuelve la conexion de BBDD
function conectaDb(){
    global $mysqlHost;
    global $mysqlUser;
    global $mysqlPassword;
    global $mysqlDatabase;

    $dsn_conbbdd="mysql:host=$mysqlHost;dbname=$mysqlDatabase;charset=utf8mb4";
    $dsn_sinbbdd="mysql:host=$mysqlHost;charset=utf8mb4";
    $usuario=$mysqlUser;
    $password=$mysqlPassword;
    try {
        //Conecto a un bbdd concreta.
        $conexion= new PDO($dsn_conbbdd,$usuario,$password);
    } catch (PDOException $e) {
        echo "<p>Error:No puede conectarse con la base de datos. {$e->getMessage()}</p>";
        try {
            $conexion= new PDO($dsn_sinbbdd,$usuario,$password);
        } catch (PDOException $e) {
            echo "<p>Error:No puede conectarse con la base de datos. {$e->getMessage()}</p>";
            die;
        }
    }
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $conexion;
}

?>