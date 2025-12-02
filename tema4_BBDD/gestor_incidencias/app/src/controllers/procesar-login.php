<?php
session_start();
require __DIR__. "/../../vendor/autoload.php";
use App\models\Basedatos;

if ($_SERVER["REQUEST_METHOD"]!=="POST") {
    header("Location:../../index.php");
    exit;
}
else{
    $todoOK=true;
    if (isset($_POST["email"])){
        $email=$_POST["email"];

        if ($email ==="") {
            //ERROR. El email no puede estar vacio
            $_SESSION["error"]["email"]="El email no puede estar vacio";
            $todoOK=false;
        }
    }
    $password = $_POST["password"]??"";
    if ($password==="") {
        $_SESSION["error"]["password"]="El password no puede estar vacio";
        $todoOK=false;
    }
    if (!$todoOK) {
        header("Location:../views/login.php");
        exit;
    }
    else{
        $mibd=new Basedatos();
        $sql="SELECT * FROM usuario WHERE email= :email";
        $parametros=[":email"=>$email];

        $sentencia=$mibd->get_data($sql,$parametros);
        if ($sentencia !==null) {
            $registroPDO=$sentencia->fetch(PDO::FETCH_OBJ);

            if (!$registroPDO) {
                //No hay tuplas
                $_SESSION["error"]["login"]="Error de login";
                enviar_log("No se encuentra el $email en la BBDD","error");
                header("Location:../views/login.php");
                exit;
            }
            else{
                if (password_verify($password,$registroPDO->password)) {
                    //Login OK
                    $_SESSION["usuario"]["nombre"]=$registroPDO->nombre;
                    $_SESSION["usuario"]["rol"]=$registroPDO->rol;
                    $_SESSION["usuario"]["id"]=$registroPDO->id;
                    enviar_log("Usuario $email logueado correctamente","info");
                    header("Location:../views/listado.php");
                    
                }
                else{
                    $_SESSION["error"]["login"]="Error de login";
                    enviar_log("Contraseña erronea de $email.","error");
                    header("Location:../views/login.php");
                    exit;                    
                }
            }
        }


    }
}
?>