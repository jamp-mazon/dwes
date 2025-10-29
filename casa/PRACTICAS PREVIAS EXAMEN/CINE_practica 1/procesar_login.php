<?php
session_start();
require_once __DIR__."/funciones/utilidades.php";

if (isset ($_SESSION["login"]) && $_SESSION["login"]===true) {
    header("Location:cartelera.php");
    die;
}
else{
    if ($_SERVER["REQUEST_METHOD"]!=="POST") {
       header("Location:login.php");
       die;
    }
    else{
        $_SESSION["errores"]=$_SESSION["errores"]??[];
        $_SESSION["mensajes"]=$_SESSION["mensajes"]??[];
        $todoOK=true;
        $email=$_POST["email"]??"";
        if (empty($email)) {
            $_SESSION["errores"][]="Email tiene que estar completo";
            $todoOK=false;
            header("Location:login.php");
            die;
        }
        else{
            $email=trim($email);
            if (!comprobarCorreo($email)) {
                $todoOK=false;
                $_SESSION["errores"][]="Error en el Email, esta mal formado o ya existe";
                header("Location:login.php");
                die;
            }
            $_SESSION["email"]=$_SESSION["email"]??$email;
            $recuerdame=$_POST["recordar"]??"";
            if (!empty($recuerdame)) {
                setcookie("email",$email,time()+(7*24*60*60),"/");
            }
            else{
                setcookie("email",$email,time()-3600,"/");//restar 1h;
            }
        }
        $password=$_POST["password"]??"";
        if (empty($password)) {
            $todoOK=false;
            $_SESSION["errores"][]="Password no puede estar vacia";
            header("Location:login.php");
            die;
        }
        else{
            $password=trim($password);
            if (!comprobarPassword($password)) {
                $todoOK=false;
                $_SESSION["errores"][]="ERROR en la contraseña";
                header("Location:login.php");
                die;
            }
        }
        if ($todoOK) {
            $_SESSION["login"]=true;
            if (comprobarAdmin($email)) {
                $_SESSION["esAdmin"]=true;
            }
            header("Location:cartelera.php");
            die;
        }
    }
}

?>