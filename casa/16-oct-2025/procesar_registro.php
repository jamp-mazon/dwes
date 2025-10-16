<?php
    session_start();
    require_once "functions/funciones.php";
    require_once "includes/Usuario.php";


    if ($_SERVER["REQUEST_METHOD"]!="POST") {
        header("Location:registrarse.php");
        die;
    }
    else{
        $todoOK=true;
        //recojo el nick
        $nick=recogerDatos("nick");
        //comprobar si ya existe ese nick
        if (is_null($nick)) {
            $todoOK=false;
            $_SESSION["errores"]["nick"]="Error en el nick";
            header("Location:registrarse.php");
            die;
        }
        else{
            $_SESSION["nick"]=$nick;

        }
        //recojo el email
        $email=recoger_email("email");
        if (is_null($email)) {
            $todoOK=false;
            $_SESSION["errores"]["email"]="Error en el email";
            header("Location:registrarse.php");
            die;
        }
        else{
            $_SESSION["email"]=$email;
        }
        //recojo las contraseñas
        $password1=recoger_password("password1");

        if (is_null($password1)) {
            $todoOK=false;
            $_SESSION["errores"]["password"]="Error en el formato de la contraseña";
            header("Location:registrarse.php");
            die;            
        }

        $password2=recoger_password("password2");

        if (is_null($password2)) {
            $todoOK=false;
            $_SESSION["errores"]["password"]="Error en el formato de la contraseña";
            header("Location:registrarse.php");
            die;            
        }
        if ($password1!==$password2) {
            $todoOK=false;
            $_SESSION["errores"]["password"]="Las contraseñas no son iguales";
            header("Location:registrarse.php");
            die;            
        }
        //entiendo que si llego aqui , los password son correctos si no me salgo antes o me redirigo a registrarse de nuevos
        //Recojo el genero.
        if (isset($_POST["genero"])) {
            $genero=$_POST["genero"];
            $_SESSION["genero"]=$genero;
        }
        else{
            $todoOK=false;
            $_SESSION["errores"]["genero"]="El genero es obligatorio";
            header("Location:registrarse.php");
            die;
        }
        //Recojo las aficiones. No compruebo si estan vacias porque ya tienen un value.
        if (isset($_POST["aficiones"]) && is_array($_POST["aficiones"])) {
            $aficiones=$_POST["aficiones"];
            $_SESSION["aficiones"]=$aficiones;
        }
        else{
            $todoOK=false;
            $_SESSION["errores"]["aficiones"]="Las aficiones son obligatorias";
            header("Location:registrarse.php");
            die;
        }
        if ($todoOK) {
            $usuario=new Usuario($nick,$email,$password1,$genero,$aficiones);
            if (is_null($usuario)) {
                $_SESSION["errores"]["usuario"]="Usuario incorrecto";
                header("Location:registrarse.php");
                die;
            }
                $_SESSION["usuario"]=$usuario;
                $_SESSION["mensajes"]["usuario"]="Usuario creado correctamente";
                
            //Implementar el guardado en el json.... y despues de comprobar que se guardan controlar email y nick.
        }        

    }


?>