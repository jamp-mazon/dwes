<?php
 include_once "includes/Usuario.php";
 function devolver_usuarios(){
    $lista_usuarios=[];
    $ruta_bbdd="bbdd/usuarios.json";
    $usuarios_json=file_get_contents($ruta_bbdd,FILE_USE_INCLUDE_PATH);
    $lista_usuarios=json_decode($usuarios_json);

    return $lista_usuarios;
 }

 function guardar_usuario($usuario){
        $ruta_bbdd="bbdd/usuarios.json";
        $usuarios_json=file_get_contents($ruta_bbdd,FILE_USE_INCLUDE_PATH);
        $lista_usuarios=devolver_usuarios();
        array_push($lista_usuarios,$usuario);
        $usuarios_json=json_encode($lista_usuarios,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
        file_put_contents($ruta_bbdd,$usuarios_json);
        
 }

?>