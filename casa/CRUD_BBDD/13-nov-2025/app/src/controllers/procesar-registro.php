<?php 
require __DIR__."/../../vendor/autoload.php";
use App\models\Basedatos;
use App\models\Usuarios;
session_start();
$_SESSION["errores"]=[];
if ($_SERVER["REQUEST_METHOD"]!="POST") {
    header("Location:../../public/index.php");
    die;
}
else{
    $todoOK=true;
    $user=$_POST["user"]??$todoOK=false && $_SESSION["errores"][]="Error: en el nombre";
    $email=$_POST["email"]??$todoOK=false && $_SESSION["errores"][]="Error: en el email";
    $password1=$_POST["password1"]??$todoOK=false && $_SESSION["errores"][]="Error: password1";
    $password2=$_POST["password2"]??$todoOK=false && $_SESSION["errores"][]="Error: password2";

    if ($todoOK) {
        if ($password1!==$password2) {
            $_SESSION["errores"][]="Error:Las contraseñas no coinciden";
                header("Location:../../public/index.php");
                die;
        }
        else{
            $actual=new DateTime("now");
            $actual=$actual->format("Y-m-d H:i:s");
            $nuevo_usuario=new Usuarios(null,$user,$email,$password1,$actual);
            $mibd=new Basedatos();
            $mibd->crear_usuario($nuevo_usuario);
            header("Location:../../public/index.php");
            exit;
        }
    }
    
}

?>