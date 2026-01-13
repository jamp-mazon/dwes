<?php

function obtener_rol($key){
    // $host="127.0.0.1";
    // $db="libros_apikey";
    // $user="root";
    // $pass="";
    // $charset="utf8mb4";
    // $motor="mysql";
    // $dns="$motor:host=$host;dbname=$db;charset=$charset";
    // try {
    //     $pdo=new PDO($dns,$user,$pass);
    //     $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    // } catch (PDOException $e) {
    //     http_response_code(500);
    //     echo json_encode("Error al conectar a la BBDD");
    //     exit();
    // }
    $pdo=conectarBBDD();
    //Si llego aqui , me he conectado a la bbdd
    try {
        $keyHash=hash("sha256",$key);
        $sql="SELECT rol from api_keys where api_key=:api_key";
        $statement=$pdo->prepare($sql);
        $statement->execute(["api_key"=>$keyHash]);

        $rol=$statement->fetchColumn();
       
        return $rol;
    } catch (PDOException $e) {
        //Seria interesante guardar el error con monolog
        http_response_code(500);
        echo json_encode("Error al conectar a la BBDD:");
        exit();
    }

}
function conectarBBDD(){
    $host="127.0.0.1";
    $db="libros_apikey";
    $user="root";
    $pass="";
    $charset="utf8mb4";
    $motor="mysql";
    $dns="$motor:host=$host;dbname=$db;charset=$charset";
    
    try {
        $pdo=new PDO($dns,$user,$pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        return $pdo;

    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode("Error al conectar a la BBDD");
        exit();
    }
}
function obtener_libros(){
    $pdo=conectarBBDD();
    $sql="SELECT * FROM libro";
    try {
        $sentencia=$pdo->prepare($sql);
        $sentencia->execute();
        $registros=$sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registros;
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(["Error"=>"Error en la conexion BBDD"]);
        exit();
    }
}
function insertarLibro($datos){
    $pdo=conectarBBDD();
    $sql="INSERT INTO libro (titulo, autor, genero) VALUES (:titulo,:autor,:genero)";
    try {
    $sentencia=$pdo->prepare($sql);
    $sentencia->bindParam(":titulo",$datos["titulo"]);
    $sentencia->bindParam(":autor",$datos["autor"]);
    $sentencia->bindParam(":genero",$datos["genero"]);
    $sentencia->execute();
    return true;
            
    } catch (PDOException $e) {
        return false;
    }
}
function obtener_libro_titulo($titulo){
    $titulo="%$titulo%";
    $pdo=conectarBBDD();
    $sql="SELECT * FROM libro WHERE titulo LIKE :titulo";
    try {
        $sentencia=$pdo->prepare($sql);
        $sentencia->bindParam(":titulo",$titulo);
        $sentencia->execute();
        $libro=$sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $libro;

    } catch (PDOException $e) {
        http_response_code(501);
        echo json_encode(["Error"=>"Error en la conexion BBDD"]);
        exit();       
    }
}
function eliminarLibro($datos){
    $titulo=urldecode($datos["titulo"])??"";
    if ($titulo==="") {
        return false;
    }
    try {
    $pdo=conectarBBDD();
    $sql="DELETE FROM libro where titulo=:titulo";
    $sentencia=$pdo->prepare($sql);
    $sentencia->bindParam(":titulo",$titulo);
    $sentencia->execute();
    return true;
    } catch (PDOException $e) {
        return false;
    }
}    

?>