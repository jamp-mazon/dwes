<?php
session_start();
include_once "includes/Usuario.php";
include_once "funciones/utilidades.php";
$_SESSION["errores"]=[];
if (isset ($_SESSION["loginOK"]) && $_SESSION["loginOK"]==true) {
    header("Location:cartelera.php");
    die;
}
else{
   if ($_SERVER["REQUEST_METHOD"]=="POST") {
        $email = $_POST["email"] ?? "";

        $password=$_POST["password"] ?? "";
    if (!empty($email) && !empty($password)) {
        $email=trim($_POST["email"]);
        $password=trim($_POST["password"]);
        if (isset($_POST["recordar"]) && $_POST["recordar"]===1) {
            setcookie("email",$email,time()+86400,"/");
        }
       if (validar_usuario($email,$password)) {
            $_SESSION["loginOK"]=true;
            $user=devolverUsuario($email);
            if (!is_null($user) && $user->esAdmin===true) {
                $_SESSION["esAdmin"]=true;
                $_SESSION["usuario"]=$user;
            }
            header("Location:cartelera.php");
            die;
        }
        else{
            $_SESSION["errores"][]="Fallo al validar el usuario";
            header("Location:login.php");
            die;
        } 
    }
    else{
        $_SESSION["errores"][]="Los campos no son correctos.";
        header("Location:login.php");
        die;
        }
    }
    else{
        $_SESSION["errores"][]="Logeate o crea un nuevo usuario.";
        header("Location:login.php");
        die;
    } 
}



?>