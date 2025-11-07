<?php
if ($_SERVER["REQUEST_METHOD"]!=="POST") {
    header("Location:../views/listado.php");
    die;
}
else{
    $id=$_POST["id"];
    $nombre=$_POST["nombre"];
    $apellidos=$_POST["apellidos"];
    $user=$_POST["user"];
    $fecha_nac=$_POST["fecha_nac"];
    $passwordClaro=$_POST["password"]??"";
    if (empty($passwordClaro)) {
        $passwordCifrado=null;
    }
    else{
        $passwordCifrado=password_hash($passwordClaro,PASSWORD_DEFAULT);
    }
    $usuario=new Usuario(
        $id,$nombre,$apellidos,$user,$passwordCifrado,new DateTime($fecha_nac)->format("Y-m-d")
    );
    $dbInstance=BaseDatos::getInstance();
    $dbInstance->actualizar_usuario($usuario);
}
?>