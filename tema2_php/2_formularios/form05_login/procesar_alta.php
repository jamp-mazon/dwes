<?php
require_once("includes/funciones.php");
include_once("modelo/usuario.php");
if ($_SERVER["REQUEST_METHOD"] !="POST") {
    header("Location: index.php");
    die;
}
else{
    //Vengo del form
    $mensaje="";
    $nombre=recoge("nombre");
    $email=recoge("email");
    $password1=recoge("password1");
    $password2=recoge("password2");

    //Validar Email
    if (!filter_var($email,FILTER_VALIDATE_EMAIL)){
        $mensaje="Email invalido";
        header("Location: alta.php?mensaje=$mensaje");
        die;
    }
   // ALUMNO:comprobar si el email ya existe.
    $lista_usuarios=[];//creo el array vacio
    $jsonData=file_get_contents("bbdd/data.json",FILE_USE_INCLUDE_PATH);//cojo los datos del json
    $lista_usuarios=json_decode($jsonData,true);//meto los datos del json en el array
    foreach ($lista_usuarios as $user) {//recorro con un fore los usuarios
        if (isset($user["email"]) && $user["email"]===$email) {//si existe ese usuario o si el usuario con su email es igual al que ya tengo 
            $mensaje="ERROR:el email ya existe...";
            header("Location:alta.php?mensaje=$mensaje");
            die;            
        }
    }        



    //Validar Password
    //ojo,"000"="00000000" -->TRUE
    if ($password1!==$password2){//utilizamos la comprobacion exigente
        $mensaje="ERROR:Las contraseñas son diferentes...";
        header("Location: alta.php?mensaje=$mensaje");
        die;
    }

    //Los Datos son correctos.
    //Recupero la lista de usuarios
    $lista_usuarios=[];
    $file="bbdd/data.json";
    $jsonData=file_get_contents($file,FILE_USE_INCLUDE_PATH);
    $lista_usuarios=json_decode($jsonData,true);
    //Me creo el objeto usuario.
    $usuario= new Usuario($nombre,$email,$password1);
    array_push($lista_usuarios,$usuario);
    $jsonData=json_encode($lista_usuarios,JSON_UNESCAPED_UNICODE |JSON_PRETTY_PRINT);
    file_put_contents($file,$jsonData);//sobreescribe el archivo con los nuevos cambios
    $mensaje="ALTA CORRECTO";
    header("Location: alta.php?mensaje=$mensaje");
    die;
    
}



