<?php
session_start();
require_once "includes/funciones.php";
if ($_SERVER["REQUEST_METHOD"]=="POST") {
    if (isset($_POST["anterior"])) {
        if (isset($_SESSION["daw1"])) {
                unset($_SESSION["daw1"]);
        }
        header("Location:formulario1.php");
        die;
    }
    if (isset($_POST["form1"])) {
        $_SESSION["errores"]=$_SESSION["errores"]??[];
        $form1OK=true;
        $nombre=$_POST["nombre"]??"";
        if (empty($nombre)) {
            $_SESSION["errores"][]="Falta el nombre";
            $form1OK=false;
        }
        $curso=$_POST["curso"]??"";
        if (empty($curso)) {
            $_SESSION["errores"][]="Hay que escoger un curso";
            $form1OK=false;
        }
        if ($form1OK) {
            $_SESSION["nombre"]=$nombre;
            $_SESSION["curso"]=$curso;
            $_SESSION["form1"]=true;
            header("Location:formulario2.php");
        }
        else{
            header("Location:formulario1.php");
            die;
        }        
    }
    if (isset($_POST["mostrar"])) {
       

        $_SESSION["errores"]=$_SESSION["errores"]??[];

        if (empty($_POST["daw"])) {
            $_SESSION["errores"][]="Escoge al menos 3 materias";
             header("Location:formulario2.php");
            die;
        }
        else{
            $daw1=[];
            $daw1=$_POST["daw"];
            if (count($daw1)<3) {
                $_SESSION["errores"][]="Son menos de 3 materias aún...";
                $_SESSION["daw1"]=$daw1;
                header("Location:formulario2.php");
                die;
            }
            else{
                $_SESSION["daw1"]=$daw1;
                $_SESSION["form2"]=true;
                header("Location:mostrar_datos.php");
                die;
            }

        }   
    }
}


?>