<?php
session_start();
require __DIR__ ."/../../vendor/autoload.php";
use App\models\Basedatos;


if ($_SERVER["REQUEST_METHOD"]!=="POST") {
    header("Location:index.php");
    die;
}
else{
    $todoOK=true;
    $_SESSION["errores"]=[];
    $email=$_POST["email"]??($todoOK=false);
    $password=$_POST["password"]??($todoOK=false);

    if (!$email) {
        $_SESSION["errores"][]="Formato email incorrecto";
    }
    if (!$password) {
        $_SESSION["errores"][]="Contraseña incorrecta";
    }
    if ($todoOK) {
        $mibd=new Basedatos();
        $sql="SELECT * FROM usuarios where email=:email";
        $parametro=[":email"=>$email];
        $sentencia=$mibd->get_data($sql,$parametro);
        $registroPDO=$sentencia->fetch(PDO::FETCH_OBJ);
        if ($registroPDO===null) {
            $log=milog("Error al recibir el email seguramente no coincida",false);
            $_SESSION["errores"][]="El email no existe en la bbdd";
            header("Location:../../public/login.php");
            die;
        }
        else{
            if (password_verify($password,$registroPDO->password_hash)) {
                $_SESSION["nombre"]=$registroPDO->nombre;
                $_SESSION["logueado"]=true;
                $_SESSION["id"]=$registroPDO->id;
                $_SESSION["email"]=$registroPDO->email;
                $_SESSION["rol"]=$registroPDO->rol;

                $log=milog("El usuario $registroPDO->nombre , con ID:$registroPDO->id ha iniciado sesion",true);
                
                header("Location:../views/listado.php");
                die;
            }
            else{
                $_SESSION["errores"][]="Error verificando password no coinciden";
                header("Location:../../public/login.php");
                die;
            }
        }
    }
    else{
        header("Location:../../public/login.php");
        exit;
    }
}

?>