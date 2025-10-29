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
 function comprobarCorreo($email){
   if (filter_var($email,FILTER_VALIDATE_EMAIL)) {   
      $lista_usuarios=[];
      $lista_usuarios=devolver_usuarios();
      $emailExiste=false;
      foreach ($lista_usuarios as $user) {
         if ($user->email===$email) {
            return true;
         }
      }
      return false;
   }
   else{
      return false;
   }
 }
 function comprobarPassword($password){
   $lista_usuarios=devolver_usuarios();
   foreach ($lista_usuarios as $user) {
         if (password_verify($password,$user->password)) {
            return true;
         }
   }
   return false;
 }
 function comprobarAdmin($email){
   $lista_usuarios=devolver_usuarios();
   foreach ($lista_usuarios as $user) {
         if ($user->email===$email) {
            if ($user->esAdmin) {
               return true;
            }
         }
      }
      return false;
 }
?>