<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
session_start();
include_once "funciones/funciones.php";

    if ($_SERVER["REQUEST_METHOD"]!="POST") {
        $no_POST="Primero tienes que iniciar sesion";
        array_push($_SESSION["errores"],$no_POST);
        header("Location:login.php");
        die;
    }
    else{
        $_SESSION['errores']=[];
        //comprobaciones del email y la contraseña
        //comprobar primero el email
        $emailOK=false;
        $passwordOK=false;
        $email=recogerEmail("email");
        if (is_null($email)) {
            $errorEmail="Error en el formato email";
            array_push($_SESSION["erorres"],$errorEmail);
            header("Location:login.php");
            die;
        }
        else{
            $emailOK=true;
        }
        $password=recogerPass("password");
        if (is_null($password)) {
            $errorPassword="Error en la contraseña";
            array_push($_SESSION["errores"],$errorPassword);
            header("Location:login.php");
            die;
        }
        else{
            $passwordOK=true;
        }
        if ($emailOK && $passwordOK) {
            
            if (comprobar_login($email,$password)) {
                $_SESSION["mensajes"]["login"]="Login Correcto!!";
                $_SESSION["login"]=true;
                header("Location:cartelera.php");
            }
            else{
                $_SESSION["login"]=false;
                $error_logeo="Algo ha fallado en el logeo...";
                array_push($_SESSION["errores"],$error_logeo);
                header("Location:login.php");
            }
        }

    }

?>